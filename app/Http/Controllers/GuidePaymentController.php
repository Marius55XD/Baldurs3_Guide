<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GuidePaymentController extends Controller
{
    private const GUIDE_PRICE_EUR = 4.99;

    public function show(string $slug): View
    {
        $guide = Guide::published()
            ->with(['category', 'author'])
            ->where('slug', $slug)
            ->firstOrFail();

        return view('guides.checkout', [
            'guide' => $guide,
            'price' => self::GUIDE_PRICE_EUR,
        ]);
    }

    public function pay(Request $request, string $slug): RedirectResponse
    {
        $guide = Guide::published()
            ->where('slug', $slug)
            ->firstOrFail();

        // Placeholder checkout completion. Replace with Stripe/PayPal integration later.
        return redirect()
            ->route('guides.show', $guide->slug)
            ->with('success', "Payment successful for '{$guide->title}'. You now have full access.");
    }
}
