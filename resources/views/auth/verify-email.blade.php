@extends('layouts.app')
@section('title', 'Verify Email')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="bg3-card p-4 p-md-5 text-center">
                <h2 class="text-gold mb-3"><i class="bi bi-envelope-check me-2"></i>Verify Your Email</h2>

                <p class="mb-4" style="color:#d8ebff;">
                    We sent a confirmation link to your email address. Open the message and click the link to finish creating your account.
                </p>

                @if (session('status') === 'verification-link-sent')
                    <div class="alert alert-success mb-4">
                        A new verification link has been sent to your email address.
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('verification.send') }}" class="d-grid gap-2">
                    @csrf
                    <button type="submit" class="btn btn-gold">
                        <i class="bi bi-send me-2"></i>Resend Verification Email
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection