@extends('layouts.app')
@section('title', 'Register')

@section('content')
@php
    $shadowheartGif = file_exists(public_path('images/shadowheart-banner.gif'))
        ? asset('images/shadowheart-banner.gif')
        : asset('images/bg3-hero.gif');
@endphp
<div class="container my-5">
    <div class="row justify-content-center align-items-stretch g-4">
        <div class="col-lg-6 d-none d-lg-block">
            <div class="bg3-card h-100 register-banner">
                <img src="{{ $shadowheartGif }}" alt="Shadowheart banner" class="register-banner-img" loading="lazy">
                <div class="register-banner-overlay">
                    <h3 class="mb-2 text-gold">Join The Party</h3>
                    <p class="mb-0">Create your account and unlock premium BG3 guide content.</p>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-xl-5">
            <div class="bg3-card p-4 p-md-5">
                <h2 class="text-gold mb-4 text-center"><i class="bi bi-person-plus me-2"></i>Create Account</h2>

                @if($errors->has('name') || $errors->has('email') || $errors->has('password') || $errors->has('password_confirmation'))
                    <div class="alert alert-danger">
                        <div>{{ $errors->first('name') ?: ($errors->first('email') ?: ($errors->first('password') ?: $errors->first('password_confirmation'))) }}</div>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" required autofocus>
                        @error('name')<div class="invalid-feedback auth-field-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" required>
                        @error('email')<div class="invalid-feedback auth-field-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')<div class="invalid-feedback auth-field-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" required>
                        @error('password_confirmation')<div class="invalid-feedback auth-field-error">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-gold w-100">Create Account</button>
                </form>

                <hr style="border-color:#3d2e0f; margin:1.5rem 0;">
                <p class="text-center mb-0" style="color:#d8ebff;">
                    Already have an account? <a href="{{ route('login') }}" class="text-gold">Sign In</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .register-banner {
        position: relative;
        overflow: hidden;
        min-height: 100%;
    }

    .register-banner-img {
        width: 100%;
        height: 100%;
        min-height: 540px;
        object-fit: cover;
        display: block;
    }

    .register-banner-overlay {
        position: absolute;
        inset: auto 0 0 0;
        padding: 1.25rem;
        background: linear-gradient(to top, rgba(3, 12, 20, 0.92), rgba(3, 12, 20, 0.12));
        color: #d8ebff;
    }
</style>
@endpush

