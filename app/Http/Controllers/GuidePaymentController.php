<?php

namespace App\Http\Controllers;

use App\Models\Guide;
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

            $purchase = $user->guidePurchases()->firstOrCreate(
                ['guide_id' => $guide->id],
                [
                    'amount' => self::GUIDE_PRICE_EUR,
                    'paid_at' => now(),
                ]
            );

            $message = $purchase->wasRecentlyCreated
                ? "Payment successful for '{$guide->title}'. You now have full access."
                : "You already purchased '{$guide->title}'. Full access is active.";

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

        $purchase = $user->guidePurchases()->firstOrCreate(
            ['guide_id' => $guide->id],
            [
                'amount' => self::GUIDE_PRICE_EUR,
                'paid_at' => now(),
            ]
        );

        $message = $purchase->wasRecentlyCreated
            ? "Payment successful for '{$guide->title}'. You now have full access."
            : "You already purchased '{$guide->title}'. Full access is active.";

        return redirect()
            ->route('guides.show', $guide->slug)
            ->with('success', $message);
    }

    private function userHasAccess($user, Guide $guide): bool
    {
        return $user->isEditor()
            || $user->id === $guide->user_id
            || $user->hasPurchasedGuide($guide);
    }

    private function getPayPalBaseUrl(): string
    {
        return (string) config('services.paypal.base_url');
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
}
