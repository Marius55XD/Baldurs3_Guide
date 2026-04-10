@extends('layouts.app')
@section('title', 'Checkout - ' . $guide->title)

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="bg3-card p-4 p-md-5">
                <h2 class="text-gold mb-4"><i class="bi bi-credit-card me-2"></i>Guide Checkout</h2>

                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                    <div>
                        <div class="small" style="color:#d8ebff;">You are purchasing access to:</div>
                        <h4 class="text-gold mb-1">{{ $guide->title }}</h4>
                        <small style="color:#d8ebff;">Category: {{ $guide->category->name }}</small>
                    </div>
                    <div class="text-md-end">
                        <div class="small" style="color:#d8ebff;">Total</div>
                        <div class="text-gold" style="font-size:1.8rem; font-weight:700;">EUR {{ number_format($price, 2) }}</div>
                    </div>
                </div>

                <p class="mb-4" style="color:#d8ebff;">
                    This is a demo checkout flow. A payment gateway can be integrated later.
                </p>

                @auth
                    @if($hasAccess)
                        <div class="alert mb-3" style="background:#0f3137; border:1px solid #1f5a64; color:#8ee5f2;">
                            You already have full access to this guide.
                        </div>
                        <a href="{{ route('guides.show', $guide->slug) }}" class="btn btn-gold">
                            <i class="bi bi-journal-text me-1"></i>Read Full Guide
                        </a>
                    @else
                        <form method="POST" action="{{ route('guides.checkout.pay', $guide->slug) }}">
                            @csrf
                            <button type="submit" class="btn btn-gold">
                                <i class="bi bi-lock-fill me-1"></i>Pay EUR {{ number_format($price, 2) }}
                            </button>
                            <a href="{{ route('guides.show', $guide->slug) }}" class="btn btn-outline-secondary ms-2">Cancel</a>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-gold">
                        <i class="bi bi-person-lock me-1"></i>Login to Continue
                    </a>
                    <a href="{{ route('guides.show', $guide->slug) }}" class="btn btn-outline-secondary ms-2">Cancel</a>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection
