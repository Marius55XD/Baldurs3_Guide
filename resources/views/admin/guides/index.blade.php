@extends('layouts.admin')
@section('title', 'Manage Guides')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div></div>
    <a href="{{ route('admin.guides.create') }}" class="btn btn-gold">
        <i class="bi bi-plus-circle me-2"></i>New Guide
    </a>
</div>

<div class="bg3-card p-0 overflow-hidden">
    <table class="table table-dark-bg table-hover mb-0">
        <thead>
            <tr>
                <th class="ps-4">Media</th>
                <th class="ps-4">Title</th>
                <th>Category</th>
                <th>Author</th>
                <th>Status</th>
                <th>Views</th>
                <th>Date</th>
                <th class="text-end pe-4">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($guides as $guide)
            <tr>
                <td class="ps-4">
                    @if($guide->featured_image)
                        <img src="{{ $guide->featured_image }}" alt="{{ $guide->title }}"
                             style="width:72px; height:48px; object-fit:cover; border-radius:6px;"
                             loading="lazy" onerror="this.style.display='none'">
                    @else
                        <small class="text-muted">No media</small>
                    @endif
                </td>
                <td class="ps-4">
                    <a href="{{ route('guides.show', $guide->slug) }}" class="text-dark text-decoration-none" target="_blank">
                        {{ Str::limit($guide->title, 50) }}
                    </a>
                </td>
                <td><small>{{ $guide->category->name }}</small></td>
                <td><small>{{ $guide->author->name }}</small></td>
                <td>
                    <span class="badge {{ $guide->status === 'published' ? 'bg-success' : 'bg-secondary' }}">
                        {{ ucfirst($guide->status) }}
                    </span>
                </td>
                <td><small>{{ number_format($guide->views) }}</small></td>
                <td><small>{{ $guide->created_at->format('M d, Y') }}</small></td>
                <td class="text-end pe-4">
                    <a href="{{ route('admin.guides.edit', $guide) }}" class="btn btn-sm btn-outline-gold me-1">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="{{ route('admin.guides.destroy', $guide) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Delete this guide?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" class="text-center py-4 text-dark">No guides yet. <a href="{{ route('admin.guides.create') }}" class="text-dark text-decoration-underline">Create one</a>.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4 d-flex justify-content-center">
    {{ $guides->links() }}
</div>
@endsection
