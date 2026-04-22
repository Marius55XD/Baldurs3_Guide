<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GuidePurchase;

class PaymentController extends Controller
{
    public function index()
    {
        $stats = [
            'total_revenue' => (float) GuidePurchase::sum('amount'),
            'total_purchases' => GuidePurchase::count(),
            'unique_buyers' => GuidePurchase::distinct('user_id')->count('user_id'),
            'last_30_days_revenue' => (float) GuidePurchase::where('paid_at', '>=', now()->subDays(30))->sum('amount'),
        ];

        $recentPurchases = GuidePurchase::with([
                'user:id,name,email',
                'guide:id,title,slug',
            ])
            ->latest('paid_at')
            ->paginate(15);

        return view('admin.payments.index', compact('stats', 'recentPurchases'));
    }
}
