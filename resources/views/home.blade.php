@extends('layouts.app')
@section('title', 'Home')

@section('content')
{{-- Hero --}}
<div class="hero-section">
    <div class="container text-center">
        <h1 class="display-4 fw-bold text-gold mb-3">
            <i class="bi bi-shield-fill-check me-3"></i>Baldur's Gate 3 Guide
        </h1>
        <p class="lead mb-4" style="color:#d8ebff; max-width:600px; margin:0 auto 1.5rem;">
            The ultimate community hub for quests, character builds, strategies, and gameplay tips.
        </p>
        <div class="d-flex justify-content-center gap-3">
            <a href="{{ route('guides.index') }}" class="btn btn-gold btn-lg px-5">
                <i class="bi bi-book me-2"></i>Browse Guides
            </a>
            @guest
                <a href="{{ route('register') }}" class="btn btn-outline-gold btn-lg px-5">
                    <i class="bi bi-person-plus me-2"></i>Join Community
                </a>
            @endguest
        </div>
    </div>
</div>

{{-- Category Cards --}}
<div class="container my-5">
    <h2 class="text-gold mb-4"><i class="bi bi-tags me-2"></i>Browse by Category</h2>
    <div class="row g-4">
        @foreach($categories as $category)
        <div class="col-md-3 col-sm-6">
            <a href="{{ route('guides.index', ['category' => $category->slug]) }}" class="text-decoration-none">
                <div class="bg3-card h-100 p-4 text-center">
                    <div class="category-icon mb-2">{{ $category->icon ?? 'ðŸ“–' }}</div>
                    <h5 class="text-gold mb-1">{{ $category->name }}</h5>
                    <p class="small mb-2" style="color:#d8ebff;">{{ $category->description }}</p>
                    <span class="badge badge-category">{{ $category->guides_count }} guide{{ $category->guides_count !== 1 ? 's' : '' }}</span>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>

{{-- Featured Guides --}}
@if($featuredGuides->count())
<div class="container my-5">
    <h2 class="text-gold mb-4"><i class="bi bi-star me-2"></i>Most Popular Guides</h2>
    <div class="row g-4">
        @foreach($featuredGuides as $guide)
        <div class="col-md-4">
            <a href="{{ route('guides.show', $guide->slug) }}" class="text-decoration-none h-100">
                <div class="bg3-card h-100 p-4 d-flex flex-column">
                    @if($guide->featured_image)
                        <img src="{{ $guide->featured_image }}" alt="{{ $guide->title }}"
                             class="w-100 rounded mb-3" style="height:180px; object-fit:cover;"
                             loading="lazy" onerror="this.style.display='none'">
                    @endif
                    <span class="badge badge-category mb-2 align-self-start">{{ $guide->category->name }}</span>
                    <h5 class="text-gold mb-2">{{ $guide->title }}</h5>
                    <p class="flex-grow-1 small" style="color:#d8ebff;">{{ $guide->excerpt }}</p>
                    <div class="d-flex justify-content-between align-items-center mt-3 small" style="color:#d8ebff;">
                        <span><i class="bi bi-person me-1"></i>{{ $guide->author->name }}</span>
                        <span><i class="bi bi-eye me-1"></i>{{ number_format($guide->views) }}</span>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- Recent Guides --}}
@if($recentGuides->count())
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-gold mb-0"><i class="bi bi-clock-history me-2"></i>Recent Guides</h2>
        <a href="{{ route('guides.index') }}" class="btn btn-outline-gold btn-sm">View All</a>
    </div>
    <div class="row g-3">
        @foreach($recentGuides as $guide)
        <div class="col-md-6">
            <div class="bg3-card p-3 d-flex gap-3 align-items-start">
                @if($guide->featured_image)
                    <img src="{{ $guide->featured_image }}" alt="{{ $guide->title }}"
                         class="rounded" style="width:84px; height:84px; object-fit:cover;"
                         loading="lazy" onerror="this.style.display='none'">
                @endif
                <div class="flex-grow-1">
                    <span class="badge badge-category mb-1">{{ $guide->category->name }}</span>
                    <h6 class="mb-1"><a href="{{ route('guides.show', $guide->slug) }}" class="text-gold text-decoration-none">{{ $guide->title }}</a></h6>
                    <small style="color:#d8ebff;"><i class="bi bi-person me-1"></i>{{ $guide->author->name }} Â· {{ $guide->created_at->diffForHumans() }}</small>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif
@endsection

