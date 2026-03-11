@extends('layouts.app')
@section('title', 'All Guides')

@section('content')
<div class="container my-5">
    <div class="row g-4">
        {{-- Sidebar --}}
        <div class="col-md-3">
            <div class="sidebar-card mb-4">
                <h6 class="text-gold mb-3"><i class="bi bi-funnel me-1"></i>Filter Guides</h6>
                <form action="{{ route('guides.index') }}" method="GET">
                    <div class="mb-3">
                        <input type="text" name="search" class="form-control form-control-sm"
                               placeholder="Searchâ€¦" value="{{ request('search') }}">
                    </div>
                    <div class="mb-3">
                        <select name="category" class="form-select form-select-sm">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->slug }}" @selected(request('category') === $cat->slug)>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-gold btn-sm w-100">Apply</button>
                    @if(request()->hasAny(['search', 'category']))
                        <a href="{{ route('guides.index') }}" class="btn btn-outline-secondary btn-sm w-100 mt-2">Clear</a>
                    @endif
                </form>
            </div>
            <div class="sidebar-card">
                <h6 class="text-gold mb-3"><i class="bi bi-tags me-1"></i>Categories</h6>
                @foreach($categories as $cat)
                    <a href="{{ route('guides.index', ['category' => $cat->slug]) }}"
                       class="d-block text-decoration-none py-1 small {{ request('category') === $cat->slug ? 'text-gold fw-bold' : '' }}"
                       style="color:#d8ebff;">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Guide Grid --}}
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-gold mb-0">
                    <i class="bi bi-book me-2"></i>
                    @if(request('category'))
                        {{ $categories->firstWhere('slug', request('category'))?->name ?? 'Category' }} Guides
                    @elseif(request('search'))
                        Results for "{{ request('search') }}"
                    @else
                        All Guides
                    @endif
                </h2>
                <small style="color:#d8ebff;">{{ $guides->total() }} guide{{ $guides->total() !== 1 ? 's' : '' }}</small>
            </div>

            @forelse($guides as $guide)
            <div class="bg3-card mb-3 p-4">
                @if($guide->featured_image)
                    <img src="{{ $guide->featured_image }}" alt="{{ $guide->title }}"
                         class="w-100 rounded mb-3" style="height:220px; object-fit:cover;"
                         loading="lazy" onerror="this.style.display='none'">
                @endif
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                    <div class="flex-grow-1">
                        <div class="mb-2">
                            <span class="badge badge-category me-2">{{ $guide->category->name }}</span>
                        </div>
                        <h5 class="mb-2">
                            <a href="{{ route('guides.show', $guide->slug) }}" class="text-gold text-decoration-none">
                                {{ $guide->title }}
                            </a>
                        </h5>
                        <p class="mb-2 small" style="color:#d8ebff;">{{ $guide->excerpt }}</p>
                        <small style="color:#d8ebff;">
                            <i class="bi bi-person me-1"></i>{{ $guide->author->name }}
                            <span class="mx-2">Â·</span>
                            <i class="bi bi-calendar me-1"></i>{{ $guide->created_at->format('M d, Y') }}
                            <span class="mx-2">Â·</span>
                            <i class="bi bi-eye me-1"></i>{{ number_format($guide->views) }} views
                        </small>
                    </div>
                    <a href="{{ route('guides.show', $guide->slug) }}" class="btn btn-outline-gold btn-sm">
                        Read <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
            @empty
            <div class="bg3-card p-5 text-center">
                <i class="bi bi-search" style="font-size:3rem; color:#3d2e0f;"></i>
                <p class="mt-3" style="color:#d8ebff;">No guides found. Try adjusting your filters.</p>
            </div>
            @endforelse

            <div class="mt-4 d-flex justify-content-center">
                {{ $guides->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

