@extends('layouts.app')
@section('title', 'Phone Support')

@push('styles')
<style>
    .phone-shell {
        padding: 1.5rem 0 2.5rem;
    }
    .support-side-title {
        color: var(--bg3-gold);
        font-weight: 700;
        margin-bottom: 1rem;
    }
    .support-side-link {
        display: block;
        color: #d8ebff;
        text-decoration: none;
        margin-bottom: 0.75rem;
    }
    .support-side-link:hover {
        color: var(--bg3-gold);
    }
</style>
@endpush

@section('content')
<div class="container phone-shell">
    <div class="row g-4">
        <aside class="col-lg-3">
            <div class="sidebar-card">
                <h2 class="h4 support-side-title">Contact Us</h2>
                <a class="support-side-link" href="{{ route('contact') }}"><i class="bi bi-envelope-fill me-2"></i>Email Support</a>
                <a class="support-side-link" href="{{ route('phone.support') }}"><i class="bi bi-telephone-fill me-2"></i>Phone Support</a>
                <a class="support-side-link mb-0" href="{{ route('faq') }}"><i class="bi bi-question-circle-fill me-2"></i>FAQ</a>
            </div>
        </aside>

        <div class="col-lg-9">
            <div class="bg3-card p-4 p-md-5">
                <h1 class="text-gold mb-3"><i class="bi bi-telephone-fill me-2"></i>Phone Support</h1>
                <p style="color:#d8ebff;">
                    If you need help, call our support line during service hours.
                </p>

                <div class="mt-4">
                    <h2 class="h5 text-gold mb-2">Support Number</h2>
                    <p class="mb-3" style="color:#d8ebff;">
                        <a href="tel:+353420000000" class="text-gold text-decoration-none">+353 42 000 0000</a>
                    </p>

                    <h2 class="h5 text-gold mb-2">Service Hours</h2>
                    <p class="mb-0" style="color:#d8ebff;">Monday to Friday, 09:00 - 17:00</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
