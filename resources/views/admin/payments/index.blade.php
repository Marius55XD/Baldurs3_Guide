@extends('layouts.admin')
@section('title', 'Payments')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="stat-card text-center">
            <div class="stat-value">EUR {{ number_format($stats['total_revenue'], 2) }}</div>
            <div class="small" style="color:#d8ebff;">Total Revenue</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card text-center">
            <div class="stat-value">{{ number_format($stats['total_purchases']) }}</div>
            <div class="small" style="color:#d8ebff;">Total Purchases</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card text-center">
            <div class="stat-value">{{ number_format($stats['unique_buyers']) }}</div>
            <div class="small" style="color:#d8ebff;">Unique Buyers</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card text-center">
            <div class="stat-value">EUR {{ number_format($stats['last_30_days_revenue'], 2) }}</div>
            <div class="small" style="color:#d8ebff;">Revenue (Last 30 Days)</div>
        </div>
    </div>
</div>

<div class="bg3-card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap" style="gap:.6rem;">
        <h5 class="text-gold mb-0">Recent Payments</h5>
        <small style="color:#d8ebff;">Newest payments first</small>
    </div>

    <div class="table-responsive">
        <table class="table table-dark-bg table-sm table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Paid At</th>
                    <th>Buyer</th>
                    <th>Guide</th>
                    <th class="text-end">Amount</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentPurchases as $purchase)
                    <tr>
                        <td>
                            <small>{{ $purchase->paid_at?->format('Y-m-d H:i') ?? '-' }}</small>
                        </td>
                        <td>
                            <div>{{ $purchase->user?->name ?? 'Unknown User' }}</div>
                            <small>{{ $purchase->user?->email ?? '-' }}</small>
                        </td>
                        <td>
                            @if($purchase->guide)
                                <a href="{{ route('guides.show', $purchase->guide->slug) }}" target="_blank" rel="noopener" class="text-decoration-none" style="color:#0f58ff; font-weight:600;">
                                    {{ $purchase->guide->title }}
                                </a>
                            @else
                                <small>Guide removed</small>
                            @endif
                        </td>
                        <td class="text-end" style="font-weight:700;">
                            EUR {{ number_format((float) $purchase->amount, 2) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4">
                            <small>No payments recorded yet.</small>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($recentPurchases->hasPages())
        <div class="admin-pagination mt-3">
            {{ $recentPurchases->links() }}
        </div>
    @endif
</div>
@endsection
