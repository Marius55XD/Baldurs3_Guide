@extends('layouts.admin')
@section('title', 'Contact Messages')

@section('content')
<div class="bg3-card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="text-gold mb-0">User Messages & Complaints</h5>
        <span class="badge bg-secondary">{{ $messages->total() }} total</span>
    </div>

    @if($messages->isEmpty())
        <p class="mb-0">No messages yet.</p>
    @else
        <div class="table-responsive">
            <table class="table table-dark-bg table-sm table-hover align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Received</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($messages as $message)
                        <tr>
                            <td>{{ $message->name }}</td>
                            <td>{{ $message->email }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($message->subject, 55) }}</td>
                            <td>
                                @if($message->read_at)
                                    <span class="badge bg-success">Read</span>
                                @else
                                    <span class="badge bg-warning text-dark">New</span>
                                @endif
                            </td>
                            <td>{{ $message->created_at->format('Y-m-d H:i') }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.contact-messages.show', $message) }}" class="btn btn-outline-secondary btn-sm">
                                    Open
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $messages->links() }}
        </div>
    @endif
</div>
@endsection
