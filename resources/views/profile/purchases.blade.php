@extends('layouts.app')
@section('title', 'My Purchases')

@section('content')
<div class="container py-5">
    <div class="row g-4">
        <div class="col-lg-3">
            <aside class="bg3-card p-4 profile-sidebar h-100">
                <h4 class="text-gold mb-3">My Profile</h4>
                <nav class="nav flex-column gap-2">
                    <a class="profile-nav-link {{ request()->routeIs('profile.show') ? 'active' : '' }}" href="{{ route('profile.show') }}">
                        <i class="bi bi-grid me-2"></i>Dashboard
                    </a>
                    <a class="profile-nav-link" href="{{ route('guides.index') }}">
                        <i class="bi bi-journal-richtext me-2"></i>My Guides
                    </a>
                    <a class="profile-nav-link {{ request()->routeIs('purchases.index') ? 'active' : '' }}" href="{{ route('purchases.index') }}">
                        <i class="bi bi-bag-check me-2"></i>My Purchases
                    </a>
                    <a class="profile-nav-link" href="{{ route('profile.show') }}#settings">
                        <i class="bi bi-gear me-2"></i>Settings
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="profile-nav-link profile-nav-button text-start w-100 border-0">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </button>
                    </form>
                </nav>
            </aside>
        </div>

        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <h2 class="fw-bold mb-0">My Purchases</h2>
                <a href="{{ route('guides.index') }}" class="btn btn-outline-gold btn-sm">
                    <i class="bi bi-search me-1"></i>Browse More Guides
                </a>
            </div>

            @forelse($purchases as $purchase)
                <div class="bg3-card p-4 mb-3">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                        <div>
                            <div class="small text-uppercase mb-1" style="color:#8fb3d9;">Purchased Guide</div>
                            <h5 class="mb-1 text-gold">{{ $purchase->guide->title }}</h5>
                            <div class="small" style="color:#d8ebff;">
                                <i class="bi bi-tag me-1"></i>{{ $purchase->guide->category->name }}
                            </div>
                            <div class="small mt-1" style="color:#d8ebff;">
                                <i class="bi bi-calendar-check me-1"></i>Purchased {{ $purchase->paid_at?->format('M d, Y \a\t H:i') }}
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="text-gold fw-semibold mb-2">EUR {{ number_format($purchase->amount, 2) }}</div>
                            <a href="{{ route('guides.show', $purchase->guide->slug) }}" class="btn btn-gold btn-sm">
                                <i class="bi bi-journal-text me-1"></i>Read Guide
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg3-card p-5 text-center">
                    <i class="bi bi-bag-x" style="font-size:2.5rem; color:#67e8f9;"></i>
                    <h5 class="mt-3 mb-2 text-gold">No purchases yet</h5>
                    <p class="mb-3" style="color:#d8ebff;">When you buy a guide, it will appear here with the purchase date and quick access link.</p>
                    <a href="{{ route('guides.index') }}" class="btn btn-gold btn-sm">Explore Guides</a>
                </div>
            @endforelse

            @if($purchases->hasPages())
                <div class="mt-4 d-flex justify-content-center">
                    {{ $purchases->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .profile-sidebar {
        position: sticky;
        top: 1.5rem;
    }

    .profile-nav-link {
        display: inline-flex;
        align-items: center;
        color: #d8ebff;
        text-decoration: none;
        padding: .45rem .6rem;
        border-radius: .5rem;
        transition: background-color .2s ease, color .2s ease;
    }

    .profile-nav-link:hover,
    .profile-nav-link.active,
    .profile-nav-button:hover {
        background-color: rgba(103, 232, 249, .12);
        color: var(--bg3-gold);
    }

    .profile-nav-button {
        background: transparent;
    }

    @media (max-width: 991px) {
        .profile-sidebar {
            position: static;
        }
    }
</style>
@endpush
