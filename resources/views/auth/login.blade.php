@extends('layouts.app')
@section('title', 'Login')

@section('content')
@php
    $loginBgGif = asset('images/guides/guide_3_1775835640.gif');
@endphp
<div class="login-bg-wrap py-5">
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="bg3-card p-4 p-md-5 login-card">
                <h2 class="text-gold mb-4 text-center"><i class="bi bi-door-open me-2"></i>Sign In</h2>

                @if($errors->has('login') || $errors->has('email') || $errors->has('password'))
                    <div class="alert alert-danger">
                        <div>{{ $errors->first('login') ?: ($errors->first('email') ?: $errors->first('password')) }}</div>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" required autofocus>
                        @error('email')<div class="invalid-feedback auth-field-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')<div class="invalid-feedback auth-field-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-4 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember" style="color:#d8ebff;">Remember me</label>
                    </div>
                    <button type="submit" class="btn btn-gold w-100">Sign In</button>
                </form>

                <hr style="border-color:#3d2e0f; margin:1.5rem 0;">
                <p class="text-center mb-0" style="color:#d8ebff;">
                    Don't have an account? <a href="{{ route('register') }}" class="text-gold">Register</a>
                </p>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@push('styles')
<style>
    .login-bg-wrap {
        position: relative;
        min-height: calc(100vh - 210px);
        background:
            linear-gradient(rgba(3, 12, 20, 0.74), rgba(3, 12, 20, 0.74)),
            url('{{ $loginBgGif }}') center center / cover no-repeat;
    }

    .login-card {
        background-color: rgba(11, 34, 51, 0.9);
        border-color: rgba(103, 232, 249, 0.35);
        backdrop-filter: blur(2px);
    }

    @media (max-width: 767.98px) {
        .login-bg-wrap {
            min-height: auto;
            background-position: 58% center;
        }
    }
</style>
@endpush

