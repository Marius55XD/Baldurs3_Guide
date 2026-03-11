@extends('layouts.app')
@section('title', $guide->title)

@section('content')
<div class="container my-5">
    <div class="row g-4">
        {{-- Main Content --}}
        <div class="col-md-8">
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb" style="background:transparent;">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-gold">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('guides.index') }}" class="text-gold">Guides</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('guides.index', ['category' => $guide->category->slug]) }}" class="text-gold">{{ $guide->category->name }}</a></li>
                    <li class="breadcrumb-item active" style="color:#d8ebff;">{{ Str::limit($guide->title, 40) }}</li>
                </ol>
            </nav>

            <div class="bg3-card p-4 p-md-5">
                @if($guide->featured_image)
                    <img src="{{ $guide->featured_image }}" alt="{{ $guide->title }}"
                         class="w-100 rounded mb-4" style="max-height:420px; object-fit:cover;"
                         loading="lazy" onerror="this.style.display='none'">
                @endif
                <span class="badge badge-category mb-3">{{ $guide->category->name }}</span>
                <h1 class="text-gold mb-3">{{ $guide->title }}</h1>

                <div class="d-flex gap-4 mb-4 small" style="color:#d8ebff;">
                    <span><i class="bi bi-person me-1"></i>{{ $guide->author->name }}</span>
                    <span><i class="bi bi-calendar me-1"></i>{{ $guide->created_at->format('F d, Y') }}</span>
                    <span><i class="bi bi-arrow-clockwise me-1"></i>Updated {{ $guide->updated_at->diffForHumans() }}</span>
                    <span><i class="bi bi-eye me-1"></i>{{ number_format($guide->views) }} views</span>
                </div>

                @if($guide->tags->count())
                    <div class="mb-4">
                        @foreach($guide->tags as $tag)
                            <span class="badge me-1" style="background-color:#2a1e0a; border:1px solid #3d2e0f; color:#d8ebff;">
                                # {{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                @endif

                <hr style="border-color:#3d2e0f;">

                <div class="guide-content mt-4" style="color:#e8d5b0;">
                    {!! nl2br(e($guide->content)) !!}
                </div>
            </div>

            @auth
                @if(auth()->user()->isEditor())
                    <div class="mt-3 d-flex gap-2">
                        <a href="{{ route('admin.guides.edit', $guide) }}" class="btn btn-outline-gold btn-sm">
                            <i class="bi bi-pencil me-1"></i>Edit Guide
                        </a>
                    </div>
                @endif
            @endauth
        </div>

        {{-- Sidebar --}}
        <div class="col-md-4">
            <div class="sidebar-card mb-4">
                <h6 class="text-gold mb-3"><i class="bi bi-info-circle me-1"></i>Guide Info</h6>
                <table class="table table-sm mb-0" style="color:#d8ebff; background:transparent;">
                    <tr style="border-color:#3d2e0f;"><td>Category</td><td class="text-end">{{ $guide->category->name }}</td></tr>
                    <tr style="border-color:#3d2e0f;"><td>Author</td><td class="text-end">{{ $guide->author->name }}</td></tr>
                    <tr style="border-color:#3d2e0f;"><td>Published</td><td class="text-end">{{ $guide->created_at->format('M d, Y') }}</td></tr>
                    <tr style="border-color:#3d2e0f; border-bottom:none;"><td>Views</td><td class="text-end">{{ number_format($guide->views) }}</td></tr>
                </table>
            </div>

            @if($related->count())
            <div class="sidebar-card">
                <h6 class="text-gold mb-3"><i class="bi bi-journal-bookmark me-1"></i>Related Guides</h6>
                @foreach($related as $rel)
                    <a href="{{ route('guides.show', $rel->slug) }}" class="d-block text-decoration-none mb-3">
                        <div style="color:#d8ebff; font-weight:600; font-size:.9rem;">{{ $rel->title }}</div>
                        <small style="color:#d8ebff;">{{ $rel->created_at->format('M d, Y') }}</small>
                    </a>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

