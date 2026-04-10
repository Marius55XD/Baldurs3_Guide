@extends('layouts.app')
@section('title', 'My Profile')

@section('content')
<div class="container py-5">
    <div class="row g-4">
        <div class="col-lg-3">
            <aside class="bg3-card p-4 profile-sidebar h-100">
                <h4 class="text-gold mb-3">My Profile</h4>
                <nav class="nav flex-column gap-2">
                    <a class="profile-nav-link {{ request()->routeIs('profile.show') ? 'active' : '' }}" href="{{ route('profile.show') }}">
                        <i class="bi bi-grid me-2"></i>Dashboard
                    </a>
                    <a class="profile-nav-link" href="{{ route('guides.index') }}">
                        <i class="bi bi-journal-richtext me-2"></i>My Guides
                    </a>
                    <a class="profile-nav-link {{ request()->routeIs('purchases.index') ? 'active' : '' }}" href="{{ route('purchases.index') }}">
                        <i class="bi bi-bag-check me-2"></i>My Purchases
                    </a>
                    <a class="profile-nav-link" href="{{ route('profile.show') }}#settings">
                        <i class="bi bi-gear me-2"></i>Settings
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="profile-nav-link profile-nav-button text-start w-100 border-0">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </button>
                    </form>
                </nav>
            </aside>
        </div>

        <div class="col-lg-9">
            <h2 class="fw-bold mb-4">Welcome, <span class="text-gold">{{ $user->name }}</span></h2>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <section class="bg3-card p-4 p-md-5 mb-4">
                <div class="text-center mb-4">
                    <div class="profile-avatar mx-auto mb-3">
                        @if($user->avatar)
                            <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }} avatar" class="profile-avatar-img">
                        @else
                            <i class="bi bi-person-circle"></i>
                        @endif
                    </div>

                    <form action="{{ route('profile.avatar.update') }}" method="POST" enctype="multipart/form-data" class="d-inline-flex flex-column align-items-center gap-2">
                        @csrf
                        <input type="file" name="avatar" class="form-control form-control-sm" style="max-width: 270px;" accept=".jpg,.jpeg,.png,.webp" required>
                        <button type="submit" class="btn btn-outline-gold btn-sm">Upload Avatar</button>
                    </form>
                </div>

                <div class="row gy-3 profile-detail-grid">
                    <div class="col-md-3 text-md-end fw-semibold">Full Name:</div>
                    <div class="col-md-9"><span class="profile-detail-value">{{ $user->name }}</span></div>

                    <div class="col-md-3 text-md-end fw-semibold">Username:</div>
                    <div class="col-md-9"><span class="profile-detail-value">{{ $user->name }}</span></div>

                    <div class="col-md-3 text-md-end fw-semibold">Email:</div>
                    <div class="col-md-9"><span class="profile-detail-value">{{ $user->email }}</span></div>

                    <div class="col-md-3 text-md-end fw-semibold">Role:</div>
                    <div class="col-md-9"><span class="profile-detail-value text-capitalize">{{ $user->role }}</span></div>
                </div>

                <div id="settings" class="mt-4 text-center">
                    <span class="text-decoration-none text-gold profile-link-muted">Settings</span>
                </div>
            </section>

            <section class="bg3-card p-4 p-md-5 mb-4">
                <h4 class="text-gold mb-3"><i class="bi bi-person-gear me-2"></i>Edit Profile</h4>
                <form action="{{ route('profile.update') }}" method="POST" class="row g-3">
                    @csrf
                    @method('PATCH')
                    <div class="col-md-6">
                        <label for="name" class="form-label">Full Name</label>
                        <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-gold">Save Profile</button>
                    </div>
                </form>
            </section>

            <section class="bg3-card p-4 p-md-5 mb-4">
                <h4 class="text-gold mb-3"><i class="bi bi-shield-lock me-2"></i>Change Password</h4>
                <form action="{{ route('profile.password.update') }}" method="POST" class="row g-3">
                    @csrf
                    @method('PATCH')
                    <div class="col-md-4">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input id="current_password" name="current_password" type="password" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label for="password" class="form-label">New Password</label>
                        <input id="password" name="password" type="password" class="form-control" minlength="8" required>
                    </div>
                    <div class="col-md-4">
                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" minlength="8" required>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-outline-gold">Update Password</button>
                    </div>
                </form>
            </section>

            <section>
                <h3 class="fw-bold mb-3">Recent Activity</h3>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <div class="bg3-card p-3 h-100">
                            <div class="small text-uppercase text-secondary">Guides</div>
                            <div class="fs-3 fw-bold text-gold">{{ $guideCount }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg3-card p-3 h-100">
                            <div class="small text-uppercase text-secondary">Published</div>
                            <div class="fs-3 fw-bold text-gold">{{ $publishedCount }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg3-card p-3 h-100">
                            <div class="small text-uppercase text-secondary">Total Views</div>
                            <div class="fs-3 fw-bold text-gold">{{ number_format($totalViews) }}</div>
                        </div>
                    </div>
                </div>

                @forelse($recentActivity as $item)
                    <div class="bg3-card p-3 mb-2 activity-item">
                        <div>{{ $item['text'] }}</div>
                        <small class="text-secondary">{{ $item['time'] }}</small>
                    </div>
                @empty
                    <div class="bg3-card p-3 mb-2 activity-item">
                        <div>No recent activity yet. Start by creating your first guide.</div>
                    </div>
                @endforelse
            </section>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .profile-sidebar {
        position: sticky;
        top: 1.5rem;
    }

    .profile-nav-link {
        display: inline-flex;
        align-items: center;
        color: #d8ebff;
        text-decoration: none;
        padding: .45rem .6rem;
        border-radius: .5rem;
        transition: background-color .2s ease, color .2s ease;
    }

    .profile-nav-link:hover,
    .profile-nav-link.active,
    .profile-nav-button:hover {
        background-color: rgba(103, 232, 249, .12);
        color: var(--bg3-gold);
    }

    .profile-nav-button {
        background: transparent;
    }

    .profile-avatar {
        width: 88px;
        height: 88px;
        border: 2px solid var(--bg3-gold);
        border-radius: 50%;
        display: grid;
        place-items: center;
        font-size: 2.4rem;
        color: var(--bg3-gold);
        background: rgba(103, 232, 249, .07);
        overflow: hidden;
    }

    .profile-avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-detail-grid {
        max-width: 640px;
        margin: 0 auto;
    }

    .profile-detail-value {
        border-bottom: 1px solid rgba(216, 235, 255, .45);
        display: inline-block;
        min-width: 230px;
        padding-bottom: .2rem;
    }

    .profile-link-muted {
        border-bottom: 1px solid rgba(103, 232, 249, .5);
        padding-bottom: 2px;
    }

    .activity-item {
        border-left: 3px solid rgba(103, 232, 249, .6);
    }

    @media (max-width: 991px) {
        .profile-sidebar {
            position: static;
        }
    }
</style>
@endpush
