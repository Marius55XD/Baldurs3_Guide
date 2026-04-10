<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GuidePaymentController extends Controller
{
    private const GUIDE_PRICE_EUR = 4.99;

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
        ]);
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
}
