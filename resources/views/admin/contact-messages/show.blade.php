@extends('layouts.admin')
@section('title', 'Contact Message')

@section('content')
<div class="bg3-card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="text-gold mb-0">{{ $contactMessage->subject }}</h5>
        <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-outline-secondary btn-sm">
            Back to Messages
        </a>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-md-6"><strong>Name:</strong> {{ $contactMessage->name }}</div>
        <div class="col-md-6"><strong>Email:</strong> {{ $contactMessage->email }}</div>
        <div class="col-md-6"><strong>Received:</strong> {{ $contactMessage->created_at->format('Y-m-d H:i:s') }}</div>
        <div class="col-md-6"><strong>IP:</strong> {{ $contactMessage->ip_address ?? 'N/A' }}</div>
    </div>

    <div class="mb-3">
        <strong>User Agent:</strong>
        <div class="small mt-1" style="word-break: break-word;">{{ $contactMessage->user_agent ?? 'N/A' }}</div>
    </div>

    <hr>

    <div>
        <strong>Message:</strong>
        <div class="mt-2" style="white-space: pre-wrap;">{{ $contactMessage->message }}</div>
    </div>
</div>
@endsection
