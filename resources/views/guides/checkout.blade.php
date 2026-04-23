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

                <p class="mb-4" style="color:#f8fbff;">
                    Choose a payment method to unlock the full guide.
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
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <div class="p-3 h-100" style="border:1px solid rgba(143,179,217,.25); border-radius:16px; background:rgba(15,27,46,.65);">
                                    <div class="d-flex justify-content-between align-items-start gap-3 mb-2">
                                        <div>
                                            <div class="small text-uppercase" style="color:#8fb3d9;">Fast checkout</div>
                                            <h5 class="mb-1 text-gold">PayPal</h5>
                                        </div>
                                        <i class="bi bi-cash-coin" style="font-size:1.7rem; color:#9ecbff;"></i>
                                    </div>
                                    @if($paypalEnabled)
                                        <p class="small mb-3" style="color:#f4fbff;">Use your PayPal account or linked card.</p>
                                        <div id="paypal-button-container" class="mb-3"></div>
                                        <div id="paypal-status-message" class="small mb-0" style="color:#f8fbff;"></div>
                                    @else
                                        <div class="alert mb-0" style="background:#6b1221; border:1px solid #ff6b7a; color:#fff7f7; font-weight:600;">
                                            PayPal is not configured yet.
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 h-100" style="border:1px solid rgba(143,179,217,.25); border-radius:16px; background:rgba(15,27,46,.65);">
                                    <div class="d-flex justify-content-between align-items-start gap-3 mb-2">
                                        <div>
                                            <div class="small text-uppercase" style="color:#8fb3d9;">Card checkout</div>
                                            <h5 class="mb-1 text-gold">Stripe</h5>
                                        </div>
                                        <i class="bi bi-credit-card-2-front" style="font-size:1.7rem; color:#9ecbff;"></i>
                                    </div>
                                    @if($stripeEnabled)
                                        <p class="small mb-3" style="color:#f4fbff;">Pay securely by card through Stripe Checkout.</p>
                                        <button type="button" id="stripe-checkout-button" class="btn btn-gold w-100">
                                            <i class="bi bi-lightning-charge-fill me-1"></i>Pay with Card
                                        </button>
                                        <div id="stripe-status-message" class="small mt-3 mb-0" style="color:#f8fbff;"></div>
                                    @else
                                        <div class="alert mb-0" style="background:#6b1221; border:1px solid #ff6b7a; color:#fff7f7; font-weight:600;">
                                            Stripe is not configured yet.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('guides.show', $guide->slug) }}" class="btn btn-outline-secondary">Cancel</a>
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
@push('styles')
<style>
    .checkout-status {
        border-radius: 12px;
        border: 1px solid transparent;
        padding: .85rem 1rem;
        font-weight: 700;
        letter-spacing: .01em;
        line-height: 1.4;
    }

    .checkout-status--info {
        background: #0c3558;
        border-color: #72d7ff;
        color: #ffffff;
    }

    .checkout-status--danger {
        background: #7f1221;
        border-color: #ff8b95;
        color: #fff7f7;
    }

    .checkout-status--warning {
        background: #7f1221;
        border-color: #ff8b95;
        color: #fff7f7;
    }
</style>
@endpush
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const paypalEnabled = @json($paypalEnabled);
        const stripeEnabled = @json($stripeEnabled);
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        const paypalContainer = document.getElementById('paypal-button-container');
        const statusMessage = document.getElementById('paypal-status-message');
        const stripeStatusMessage = document.getElementById('stripe-status-message');
        const stripeButton = document.getElementById('stripe-checkout-button');
        const orderUrl = @json(route('guides.checkout.paypal.order', $guide->slug));
        const captureUrl = @json(route('guides.checkout.paypal.capture', $guide->slug));
        const stripeSessionUrl = @json(route('guides.checkout.stripe.session', $guide->slug));

        const showStatus = function (element, message, type) {
            if (!element) {
                return;
            }

            element.className = 'small mb-3 checkout-status checkout-status--' + (type || 'info');
            element.textContent = message;
        };

        if (paypalEnabled) {
            if (!paypalContainer || typeof paypal === 'undefined') {
                showStatus(statusMessage, 'PayPal failed to load. Refresh the page and try again.', 'danger');
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
                    showStatus(statusMessage, 'Opening PayPal checkout...', 'info');

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
                    showStatus(statusMessage, 'Completing your payment...', 'info');

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
                        showStatus(statusMessage, payload.message, 'info');
                    }

                    if (payload.redirectUrl) {
                        window.location.href = payload.redirectUrl;
                    }
                },
                onCancel: function () {
                    showStatus(statusMessage, 'PayPal checkout was cancelled.', 'danger');
                },
                onError: function (error) {
                    showStatus(statusMessage, error?.message || 'PayPal checkout failed. Please try again.', 'danger');
                }
            }).render(paypalContainer).catch(function () {
                showStatus(statusMessage, 'PayPal checkout could not be rendered. Please refresh and try again.', 'danger');
            });
        }

        if (stripeEnabled && stripeButton) {
            stripeButton.addEventListener('click', async function () {
                if (stripeStatusMessage) {
                    stripeStatusMessage.className = 'small mt-3 mb-0 checkout-status checkout-status--info';
                    stripeStatusMessage.textContent = 'Opening Stripe checkout...';
                }

                try {
                    const response = await fetch(stripeSessionUrl, {
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
                            return;
                        }

                        throw new Error(payload.message || 'Could not initialize Stripe checkout.');
                    }

                    if (!payload.url) {
                        throw new Error('Stripe checkout did not return a redirect URL.');
                    }

                    window.location.href = payload.url;
                } catch (error) {
                    if (stripeStatusMessage) {
                        stripeStatusMessage.className = 'small mt-3 mb-0 checkout-status checkout-status--danger';
                        stripeStatusMessage.textContent = error?.message || 'Stripe checkout failed. Please try again.';
                    }
                }
            });
        }
    });
</script>
@endpush
