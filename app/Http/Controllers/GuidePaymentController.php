<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use App\Models\GuidePurchase;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Throwable;

class GuidePaymentController extends Controller
{
    private const GUIDE_PRICE_EUR = 4.99;
    private const CURRENCY_CODE = 'EUR';
    private const STRIPE_UNIT_AMOUNT = 499;

    public function show(Request $request, string $slug): View
    {
        $guide = Guide::published()
            ->with(['category', 'author'])
            ->where('slug', $slug)
            ->firstOrFail();

        $user = $request->user();
        $hasAccess = false;

        if ($user) {
            $hasAccess = $user->isEditor()
                || $user->id === $guide->user_id
                || $user->hasPurchasedGuide($guide);
        }

        return view('guides.checkout', [
            'guide' => $guide,
            'price' => self::GUIDE_PRICE_EUR,
            'hasAccess' => $hasAccess,
            'paypalEnabled' => (bool) config('services.paypal.client_id') && (bool) config('services.paypal.client_secret'),
            'paypalClientId' => (string) config('services.paypal.client_id', ''),
            'paypalCurrency' => self::CURRENCY_CODE,
            'stripeEnabled' => (bool) config('services.stripe.secret'),
            'stripeCurrency' => strtolower(self::CURRENCY_CODE),
        ]);
    }

    public function createPayPalOrder(Request $request, string $slug): JsonResponse
    {
        $guide = Guide::published()
            ->where('slug', $slug)
            ->firstOrFail();

        $user = $request->user();

        if ($this->userHasAccess($user, $guide)) {
            return response()->json([
                'message' => 'You already have full access to this guide.',
                'redirectUrl' => route('guides.show', $guide->slug),
            ], 409);
        }

        try {
            $accessToken = $this->getPayPalAccessToken();

            $response = Http::withToken($accessToken)
                ->acceptJson()
                ->post($this->getPayPalBaseUrl() . '/v2/checkout/orders', [
                    'intent' => 'CAPTURE',
                    'purchase_units' => [[
                        'custom_id' => (string) $guide->id,
                        'description' => 'BG3 Guide purchase: ' . $guide->title,
                        'amount' => [
                            'currency_code' => self::CURRENCY_CODE,
                            'value' => number_format(self::GUIDE_PRICE_EUR, 2, '.', ''),
                        ],
                    ]],
                ]);

            if (!$response->successful() || !$response->json('id')) {
                Log::warning('PayPal order creation failed', [
                    'status' => $response->status(),
                    'body' => $response->json(),
                    'guide_id' => $guide->id,
                    'user_id' => $user->id,
                ]);

                return response()->json([
                    'message' => 'Could not initialize PayPal checkout. Please try again.',
                ], 422);
            }

            return response()->json([
                'id' => $response->json('id'),
            ]);
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'message' => 'Payment service is currently unavailable. Please try again shortly.',
            ], 500);
        }
    }

    public function capturePayPalOrder(Request $request, string $slug): JsonResponse
    {
        $guide = Guide::published()
            ->where('slug', $slug)
            ->firstOrFail();

        $validated = $request->validate([
            'orderID' => ['required', 'string'],
        ]);

        $user = $request->user();

        if ($this->userHasAccess($user, $guide)) {
            return response()->json([
                'success' => true,
                'message' => 'You already purchased this guide. Full access is active.',
                'redirectUrl' => route('guides.show', $guide->slug),
            ]);
        }

        try {
            $accessToken = $this->getPayPalAccessToken();

            $response = Http::withToken($accessToken)
                ->acceptJson()
                ->withBody('{}', 'application/json')
                ->post($this->getPayPalBaseUrl() . '/v2/checkout/orders/' . $validated['orderID'] . '/capture');

            if (!$response->successful()) {
                Log::warning('PayPal capture failed', [
                    'status' => $response->status(),
                    'body' => $response->json(),
                    'guide_id' => $guide->id,
                    'user_id' => $user->id,
                    'order_id' => $validated['orderID'],
                ]);

                return response()->json([
                    'message' => 'PayPal could not capture this payment. Please try again.',
                ], 422);
            }

            $status = (string) $response->json('status');
            $captureStatus = (string) $response->json('purchase_units.0.payments.captures.0.status');

            if ($status !== 'COMPLETED' || $captureStatus !== 'COMPLETED') {
                Log::warning('PayPal capture not completed', [
                    'status' => $status,
                    'capture_status' => $captureStatus,
                    'body' => $response->json(),
                    'guide_id' => $guide->id,
                    'user_id' => $user->id,
                    'order_id' => $validated['orderID'],
                ]);

                return response()->json([
                    'message' => 'Payment was not completed. Please try again.',
                ], 422);
            }

            $purchase = $this->createPurchase($user, $guide);
            $message = $this->purchaseMessage($purchase, $guide);

            return response()->json([
                'success' => true,
                'message' => $message,
                'redirectUrl' => route('guides.show', $guide->slug),
            ]);
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'message' => 'Payment service is currently unavailable. Please try again shortly.',
            ], 500);
        }
    }

    public function pay(Request $request, string $slug): RedirectResponse
    {
        $guide = Guide::published()
            ->where('slug', $slug)
            ->firstOrFail();

        $user = $request->user();

        if ($user->isEditor() || $user->id === $guide->user_id) {
            return redirect()
                ->route('guides.show', $guide->slug)
                ->with('success', 'You already have full access to this guide.');
        }

            $purchase = $this->createPurchase($user, $guide);
            $message = $this->purchaseMessage($purchase, $guide);

        return redirect()
            ->route('guides.show', $guide->slug)
            ->with('success', $message);
    }

    public function createStripeSession(Request $request, string $slug): JsonResponse
    {
        $guide = Guide::published()
            ->where('slug', $slug)
            ->firstOrFail();

        $user = $request->user();

        if ($this->userHasAccess($user, $guide)) {
            return response()->json([
                'message' => 'You already have full access to this guide.',
                'redirectUrl' => route('guides.show', $guide->slug),
            ], 409);
        }

        try {
            $response = Http::withBasicAuth($this->getStripeSecretKey(), '')
                ->asForm()
                ->acceptJson()
                ->post($this->getStripeBaseUrl() . '/v1/checkout/sessions', [
                    'mode' => 'payment',
                    'success_url' => route('guides.checkout.stripe.success', $guide->slug) . '?session_id={CHECKOUT_SESSION_ID}',
                    'cancel_url' => route('guides.checkout', $guide->slug),
                    'client_reference_id' => (string) $user->id,
                    'customer_email' => $user->email,
                    'metadata[guide_id]' => (string) $guide->id,
                    'metadata[user_id]' => (string) $user->id,
                    'line_items[0][quantity]' => 1,
                    'line_items[0][price_data][currency]' => strtolower(self::CURRENCY_CODE),
                    'line_items[0][price_data][unit_amount]' => self::STRIPE_UNIT_AMOUNT,
                    'line_items[0][price_data][product_data][name]' => 'BG3 Guide purchase: ' . $guide->title,
                    'line_items[0][price_data][product_data][description]' => 'Unlock full access to ' . $guide->title,
                ]);

            if (!$response->successful() || !$response->json('id') || !$response->json('url')) {
                Log::warning('Stripe session creation failed', [
                    'status' => $response->status(),
                    'body' => $response->json(),
                    'guide_id' => $guide->id,
                    'user_id' => $user->id,
                ]);

                return response()->json([
                    'message' => 'Could not initialize Stripe checkout. Please try again.',
                ], 422);
            }

            return response()->json([
                'id' => $response->json('id'),
                'url' => $response->json('url'),
            ]);
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'message' => 'Payment service is currently unavailable. Please try again shortly.',
            ], 500);
        }
    }

    public function stripeSuccess(Request $request, string $slug): RedirectResponse
    {
        $guide = Guide::published()
            ->where('slug', $slug)
            ->firstOrFail();

        $validated = $request->validate([
            'session_id' => ['required', 'string'],
        ]);

        $user = $request->user();

        if ($this->userHasAccess($user, $guide)) {
            return redirect()
                ->route('guides.show', $guide->slug)
                ->with('success', 'You already have full access to this guide.');
        }

        try {
            $response = Http::withBasicAuth($this->getStripeSecretKey(), '')
                ->acceptJson()
                ->get($this->getStripeBaseUrl() . '/v1/checkout/sessions/' . $validated['session_id']);

            if (!$response->successful()) {
                Log::warning('Stripe session lookup failed', [
                    'status' => $response->status(),
                    'body' => $response->json(),
                    'guide_id' => $guide->id,
                    'user_id' => $user->id,
                    'session_id' => $validated['session_id'],
                ]);

                return redirect()
                    ->route('guides.checkout', $guide->slug)
                    ->with('error', 'Stripe could not verify this payment. Please try again.');
            }

            $sessionGuideId = (string) data_get($response->json(), 'metadata.guide_id');
            $sessionUserId = (string) data_get($response->json(), 'metadata.user_id');
            $status = (string) $response->json('status');
            $paymentStatus = (string) $response->json('payment_status');

            if ($status !== 'complete' || $paymentStatus !== 'paid' || $sessionGuideId !== (string) $guide->id || $sessionUserId !== (string) $user->id) {
                Log::warning('Stripe session verification failed', [
                    'guide_id' => $guide->id,
                    'user_id' => $user->id,
                    'session_id' => $validated['session_id'],
                    'session_status' => $status,
                    'payment_status' => $paymentStatus,
                    'session_guide_id' => $sessionGuideId,
                    'session_user_id' => $sessionUserId,
                ]);

                return redirect()
                    ->route('guides.checkout', $guide->slug)
                    ->with('error', 'Stripe payment was not completed. Please try again.');
            }

            $purchase = $this->createPurchase($user, $guide);
            $message = $this->purchaseMessage($purchase, $guide);

            return redirect()
                ->route('guides.show', $guide->slug)
                ->with('success', $message);
        } catch (Throwable $exception) {
            report($exception);

            return redirect()
                ->route('guides.checkout', $guide->slug)
                ->with('error', 'Stripe is currently unavailable. Please try again shortly.');
        }
    }

    private function userHasAccess(?User $user, Guide $guide): bool
    {
        if (!$user) {
            return false;
        }

        return $user->isEditor()
            || $user->id === $guide->user_id
            || $user->hasPurchasedGuide($guide);
    }

    private function createPurchase(User $user, Guide $guide): GuidePurchase
    {
        return $user->guidePurchases()->firstOrCreate(
            ['guide_id' => $guide->id],
            [
                'amount' => self::GUIDE_PRICE_EUR,
                'paid_at' => now(),
            ]
        );
    }

    private function purchaseMessage(GuidePurchase $purchase, Guide $guide): string
    {
        return $purchase->wasRecentlyCreated
            ? "Payment successful for '{$guide->title}'. You now have full access."
            : "You already purchased '{$guide->title}'. Full access is active.";
    }

    private function getPayPalBaseUrl(): string
    {
        return rtrim((string) config('services.paypal.base_url'), '/');
    }

    private function getPayPalAccessToken(): string
    {
        $clientId = (string) config('services.paypal.client_id');
        $clientSecret = (string) config('services.paypal.client_secret');

        if ($clientId === '' || $clientSecret === '') {
            throw new \RuntimeException('PayPal credentials are not configured.');
        }

        $response = Http::asForm()
            ->withBasicAuth($clientId, $clientSecret)
            ->acceptJson()
            ->post($this->getPayPalBaseUrl() . '/v1/oauth2/token', [
                'grant_type' => 'client_credentials',
            ]);

        if (!$response->successful() || !$response->json('access_token')) {
            throw new \RuntimeException('Failed to obtain PayPal access token.');
        }

        return (string) $response->json('access_token');
    }

    private function getStripeBaseUrl(): string
    {
        return rtrim((string) config('services.stripe.base_url'), '/');
    }

    private function getStripeSecretKey(): string
    {
        $secretKey = (string) config('services.stripe.secret');

        if ($secretKey === '') {
            throw new \RuntimeException('Stripe credentials are not configured.');
        }

        return $secretKey;
    }
}
