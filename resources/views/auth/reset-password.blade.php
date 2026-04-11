@extends('layouts.app')
@section('title', 'Reset Password')

@section('content')
@php
    $loginBgGif = asset('images/guides/guide_3_1775835640.gif');
@endphp
<div class="login-bg-wrap py-5">
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="bg3-card p-4 p-md-5 login-card">
                <h2 class="text-gold mb-3 text-center"><i class="bi bi-shield-lock me-2"></i>Set New Password</h2>
                <p class="text-center mb-4" style="color:#d8ebff;">Choose a new password for your account.</p>

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.update') }}" novalidate>
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $request->email) }}" required autofocus>
                        @error('email')<div class="invalid-feedback auth-field-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')<div class="invalid-feedback auth-field-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-gold w-100">Reset Password</button>
                </form>

                <hr style="border-color:#3d2e0f; margin:1.5rem 0;">
                <p class="text-center mb-0" style="color:#d8ebff;">
                    <a href="{{ route('login') }}" class="text-gold">Back to Sign In</a>
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