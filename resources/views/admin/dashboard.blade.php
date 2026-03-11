@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<div class="row g-4 mb-5">
    <div class="col-md-2 col-sm-4 col-6">
        <div class="stat-card text-center">
            <div class="stat-value">{{ $stats['total_guides'] }}</div>
            <div class="small" style="color:#d8ebff;">Total Guides</div>
        </div>
    </div>
    <div class="col-md-2 col-sm-4 col-6">
        <div class="stat-card text-center">
            <div class="stat-value">{{ $stats['published_guides'] }}</div>
            <div class="small" style="color:#d8ebff;">Published</div>
        </div>
    </div>
    <div class="col-md-2 col-sm-4 col-6">
        <div class="stat-card text-center">
            <div class="stat-value">{{ $stats['draft_guides'] }}</div>
            <div class="small" style="color:#d8ebff;">Drafts</div>
        </div>
    </div>
    <div class="col-md-2 col-sm-4 col-6">
        <div class="stat-card text-center">
            <div class="stat-value">{{ $stats['total_categories'] }}</div>
            <div class="small" style="color:#d8ebff;">Categories</div>
        </div>
    </div>
    <div class="col-md-2 col-sm-4 col-6">
        <div class="stat-card text-center">
            <div class="stat-value">{{ $stats['total_users'] }}</div>
            <div class="small" style="color:#d8ebff;">Users</div>
        </div>
    </div>
    <div class="col-md-2 col-sm-4 col-6">
        <div class="stat-card text-center">
            <div class="stat-value">{{ number_format($stats['total_views']) }}</div>
            <div class="small" style="color:#d8ebff;">Total Views</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-8">
        <div class="bg3-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="text-gold mb-0">Recent Guides</h5>
                <a href="{{ route('admin.guides.create') }}" class="btn btn-gold btn-sm">
                    <i class="bi bi-plus me-1"></i>New Guide
                </a>
            </div>
            <table class="table table-dark-bg table-sm table-hover">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentGuides as $guide)
                    <tr>
                        <td>
                            <a href="{{ route('admin.guides.edit', $guide) }}" class="text-gold text-decoration-none">
                                {{ Str::limit($guide->title, 45) }}
                            </a>
                        </td>
                        <td><small>{{ $guide->category->name }}</small></td>
                        <td>
                            <span class="badge {{ $guide->status === 'published' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($guide->status) }}
                            </span>
                        </td>
                        <td><small>{{ $guide->created_at->format('M d') }}</small></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <a href="{{ route('admin.guides.index') }}" class="btn btn-outline-secondary btn-sm">View All Guides</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="bg3-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="text-gold mb-0">Quick Actions</h5>
            </div>
            <div class="d-grid gap-2">
                <a href="{{ route('admin.guides.create') }}" class="btn btn-gold">
                    <i class="bi bi-plus-circle me-2"></i>Create New Guide
                </a>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-gold">
                    <i class="bi bi-tag me-2"></i>Add Category
                </a>
                <a href="{{ url('/') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-eye me-2"></i>View Public Site
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

