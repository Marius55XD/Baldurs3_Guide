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
                        <div class="small" style="color:#ffffff;">You are purchasing access to:</div>
                        <h4 class="text-gold mb-1">{{ $guide->title }}</h4>
                        <small style="color:#ffffff;">Category: {{ $guide->category->name }}</small>
                    </div>
                    <div class="text-md-end">
                        <div class="small" style="color:#ffffff;">Total</div>
                        <div class="text-gold" style="font-size:1.8rem; font-weight:700;">EUR {{ number_format($price, 2) }}</div>
                    </div>
                </div>

                <p class="mb-4" style="color:#ffffff;">
                    Complete your payment with PayPal to unlock the full guide.
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
                        @if($paypalEnabled)
                            <div class="alert mb-3" style="background:#0f3137; border:1px solid #1f5a64; color:#ffffff;">
                                Complete your purchase with PayPal to unlock the full guide.
                            </div>
                            <div id="paypal-button-container" class="mb-3"></div>
                            <div id="paypal-status-message" class="small mb-3" style="color:#ffffff;"></div>
                            <a href="{{ route('guides.show', $guide->slug) }}" class="btn btn-outline-secondary">Cancel</a>
                        @else
                            <div class="alert mb-3" style="background:#3a121f; border:1px solid #6b2b40; color:#ffffff;">
                                PayPal is not configured yet. Add the PayPal credentials in your environment file to enable checkout.
                            </div>
                            <a href="{{ route('guides.show', $guide->slug) }}" class="btn btn-outline-secondary">Cancel</a>
                        @endif
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

@push('scripts')
@if($paypalEnabled)
<script src="https://www.paypal.com/sdk/js?client-id={{ rawurlencode($paypalClientId) }}&currency={{ rawurlencode($paypalCurrency) }}&intent=capture&disable-funding=card"></script>
@endif
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const paypalEnabled = @json($paypalEnabled);
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        const paypalContainer = document.getElementById('paypal-button-container');
        const statusMessage = document.getElementById('paypal-status-message');
        const orderUrl = @json(route('guides.checkout.paypal.order', $guide->slug));
        const captureUrl = @json(route('guides.checkout.paypal.capture', $guide->slug));

        const showStatus = function (message, type) {
            if (!statusMessage) {
                return;
            }

            statusMessage.className = 'small mb-3 alert alert-' + (type || 'info');
            statusMessage.textContent = message;
        };

        if (paypalEnabled) {
            if (!paypalContainer || typeof paypal === 'undefined') {
                showStatus('PayPal failed to load. Refresh the page and try again.', 'danger');
                return;
            }

            paypal.Buttons({
                style: {
                    layout: 'vertical',
                    color: 'gold',
                    shape: 'rect',
                    label: 'paypal'
                },
                createOrder: async function () {
                    showStatus('Opening PayPal checkout...', 'info');

                    const response = await fetch(orderUrl, {
                        method: 'POST',
                        credentials: 'same-origin',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: JSON.stringify({}),
                    });

                    const payload = await response.json().catch(function () {
                        return {};
                    });

                    if (!response.ok) {
                        if (response.status === 409 && payload.redirectUrl) {
                            window.location.href = payload.redirectUrl;
                            return null;
                        }

                        throw new Error(payload.message || 'Could not initialize PayPal checkout.');
                    }

                    return payload.id;
                },
                onApprove: async function (data) {
                    showStatus('Completing your payment...', 'info');

                    const response = await fetch(captureUrl, {
                        method: 'POST',
                        credentials: 'same-origin',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: JSON.stringify({
                            orderID: data.orderID,
                        }),
                    });

                    const payload = await response.json().catch(function () {
                        return {};
                    });

                    if (!response.ok) {
                        throw new Error(payload.message || 'PayPal could not capture this payment.');
                    }

                    if (payload.message) {
                        showStatus(payload.message, 'success');
                    }

                    if (payload.redirectUrl) {
                        window.location.href = payload.redirectUrl;
                    }
                },
                onCancel: function () {
                    showStatus('PayPal checkout was cancelled.', 'warning');
                },
                onError: function (error) {
                    showStatus(error?.message || 'PayPal checkout failed. Please try again.', 'danger');
                }
            }).render(paypalContainer).catch(function () {
                showStatus('PayPal checkout could not be rendered. Please refresh and try again.', 'danger');
            });
            return;
        }
    });
</script>
@endpush
