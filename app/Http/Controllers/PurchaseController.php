<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class PurchaseController extends Controller
{
    public function index(Request $request): View
    {
        $purchases = $request->user()
            ->guidePurchases()
            ->with('guide.category')
            ->latest('paid_at')
            ->paginate(12);

        return view('profile.purchases', [
            'purchases' => $purchases,
        ]);
    }
}
