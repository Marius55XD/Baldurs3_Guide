@extends('layouts.app')
@section('title', 'Phone Support')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
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
