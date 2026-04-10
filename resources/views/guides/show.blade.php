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

                @if(!$hasFullAccess)
                    <div class="mb-4">
                        <a href="{{ route('guides.checkout', $guide->slug) }}" class="btn btn-gold">
                            <i class="bi bi-credit-card me-1"></i>Unlock Full Guide
                        </a>
                    </div>
                @endif

                @if($hasFullAccess && $guide->tags->count())
                    <div class="mb-4">
                        @foreach($guide->tags as $tag)
                            <span class="badge me-1" style="background-color:#2a1e0a; border:1px solid #3d2e0f; color:#d8ebff;">
                                # {{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                @endif

                <hr style="border-color:#3d2e0f;">

                @if($hasFullAccess)
                    <div class="guide-content mt-4" style="color:#e8d5b0;">
                        {!! nl2br(e($guide->content)) !!}
                    </div>
                @else
                    <div class="guide-content mt-4" style="color:#e8d5b0;">
                        {!! nl2br(e($previewContent)) !!}
                    </div>
                    <div class="alert mt-4" style="background:#0f3137; border:1px solid #1f5a64; color:#8ee5f2;">
                        <strong><i class="bi bi-lock-fill me-1"></i>Preview mode:</strong>
                        You are viewing only the beginning of this guide. Complete payment to unlock the full content.
                        <div class="mt-3">
                            <a href="{{ route('guides.checkout', $guide->slug) }}" class="btn btn-gold btn-sm">
                                <i class="bi bi-credit-card me-1"></i>Pay and Unlock
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            @if($hasFullAccess)
                <div class="bg3-card p-4 p-md-5 mt-4">
                    <h4 class="text-gold mb-3"><i class="bi bi-question-circle me-2"></i>Guide FAQ</h4>
                    <div class="accordion" id="guideFaqAccordion">
                        <div class="accordion-item" style="background-color:#0f2a3e; border-color:#1e3a53;">
                            <h2 class="accordion-header" id="guideFaqOneHeader">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#guideFaqOne" aria-expanded="true" aria-controls="guideFaqOne" style="background-color:#123047; color:#d8ebff;">
                                    Is this guide updated for recent game patches?
                                </button>
                            </h2>
                            <div id="guideFaqOne" class="accordion-collapse collapse show" aria-labelledby="guideFaqOneHeader" data-bs-parent="#guideFaqAccordion">
                                <div class="accordion-body" style="background-color:#0e2436; color:#d8ebff;">
                                    This guide reflects the latest version available in our site and is reviewed when major patch changes affect gameplay.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item" style="background-color:#0f2a3e; border-color:#1e3a53;">
                            <h2 class="accordion-header" id="guideFaqTwoHeader">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#guideFaqTwo" aria-expanded="false" aria-controls="guideFaqTwo" style="background-color:#123047; color:#d8ebff;">
                                    Can I use this guide if I am new to BG3?
                                </button>
                            </h2>
                            <div id="guideFaqTwo" class="accordion-collapse collapse" aria-labelledby="guideFaqTwoHeader" data-bs-parent="#guideFaqAccordion">
                                <div class="accordion-body" style="background-color:#0e2436; color:#d8ebff;">
                                    Yes. The steps are written to be clear for beginners while still useful for experienced players.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item" style="background-color:#0f2a3e; border-color:#1e3a53;">
                            <h2 class="accordion-header" id="guideFaqThreeHeader">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#guideFaqThree" aria-expanded="false" aria-controls="guideFaqThree" style="background-color:#123047; color:#d8ebff;">
                                    What should I do if a step does not work as expected?
                                </button>
                            </h2>
                            <div id="guideFaqThree" class="accordion-collapse collapse" aria-labelledby="guideFaqThreeHeader" data-bs-parent="#guideFaqAccordion">
                                <div class="accordion-body" style="background-color:#0e2436; color:#d8ebff;">
                                    Check your game choices and party setup first. If the issue persists, send us feedback through Contact Us with the guide title and step details.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

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

