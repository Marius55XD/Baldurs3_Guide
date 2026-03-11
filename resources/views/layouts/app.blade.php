<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BG3 Guide') — Baldur\'s Gate 3 Guide</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    @php
        $hero4kGifExists = file_exists(public_path('images/bg3-hero-4k.gif'));
        $hero4kExists = file_exists(public_path('images/bg3-hero-4k.jpg'));
        $heroGifExists = file_exists(public_path('images/bg3-hero.gif'));
        $heroMediaUrl = $hero4kGifExists
            ? asset('images/bg3-hero-4k.gif')
            : ($heroGifExists
                ? asset('images/bg3-hero.gif')
                : ($hero4kExists ? asset('images/bg3-hero-4k.jpg') : null));
    @endphp
    <style>
        :root {
            --bg3-gold: #67e8f9;
            --bg3-dark: #061522;
            --bg3-darker: #030c14;
            --bg3-card: #0b2233;
            --bg3-border: #1e3a53;
            --bg3-hero-media: @if($heroMediaUrl) url('{{ $heroMediaUrl }}') @else none @endif;
        }
        body {
            background-color: var(--bg3-dark);
            color: #d8ebff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar {
            background-color: var(--bg3-darker) !important;
            border-bottom: 2px solid var(--bg3-gold);
        }
        .navbar-brand { color: var(--bg3-gold) !important; font-weight: 700; font-size: 1.4rem; }
        .nav-link { color: #d8ebff !important; }
        .nav-link:hover { color: var(--bg3-gold) !important; }
        .bg3-card {
            background-color: var(--bg3-card);
            border: 1px solid var(--bg3-border);
            border-radius: 8px;
        }
        .bg3-card:hover { border-color: var(--bg3-gold); transition: border-color .2s; }
        .btn-gold {
            background-color: var(--bg3-gold);
            color: var(--bg3-dark);
            border: none;
            font-weight: 600;
        }
        .btn-gold:hover { background-color: #a5f3fc; color: var(--bg3-dark); }
        .btn-outline-gold {
            border-color: var(--bg3-gold);
            color: var(--bg3-gold);
        }
        .btn-outline-gold:hover { background-color: var(--bg3-gold); color: var(--bg3-dark); }
        .btn-outline-secondary {
            border-color: #8fb3d9;
            color: #d8ebff;
        }
        .btn-outline-secondary:hover,
        .btn-outline-secondary:focus {
            background-color: #8fb3d9;
            border-color: #8fb3d9;
            color: #05121d;
        }
        .badge-category {
            background-color: var(--bg3-gold);
            color: var(--bg3-dark);
            font-weight: 600;
        }
        .hero-section {
            position: relative;
            overflow: hidden;
            background:
                linear-gradient(120deg, rgba(3, 12, 20, 0.58) 0%, rgba(11, 34, 51, 0.42) 45%, rgba(15, 60, 87, 0.52) 100%),
                var(--bg3-hero-media) center center / cover no-repeat,
                linear-gradient(135deg, var(--bg3-darker) 0%, #0f3c57 100%);
            border-bottom: 2px solid var(--bg3-gold);
            padding: 80px 0;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            inset: -15% -10%;
            background:
                radial-gradient(circle at 15% 30%, rgba(103, 232, 249, 0.08) 0%, rgba(103, 232, 249, 0) 45%),
                radial-gradient(circle at 85% 65%, rgba(56, 189, 248, 0.06) 0%, rgba(56, 189, 248, 0) 50%),
                radial-gradient(circle at 45% 80%, rgba(14, 116, 144, 0.14) 0%, rgba(14, 116, 144, 0) 55%);
            animation: heroAurora 14s ease-in-out infinite alternate;
            pointer-events: none;
        }
        .hero-section::after {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at center, rgba(6, 21, 34, 0.06) 0%, rgba(3, 12, 20, 0.3) 100%);
            pointer-events: none;
        }
        .hero-section .container {
            position: relative;
            z-index: 2;
        }
        @keyframes heroAurora {
            0% { transform: translate3d(-2%, -1%, 0) scale(1); opacity: .75; }
            50% { transform: translate3d(2%, 1%, 0) scale(1.04); opacity: .95; }
            100% { transform: translate3d(0, 0, 0) scale(1.02); opacity: .8; }
        }
        .guide-content { line-height: 1.8; }
        .guide-content h2, .guide-content h3 { color: var(--bg3-gold); margin-top: 2rem; }
        .category-icon { font-size: 2.5rem; color: var(--bg3-gold); }
        footer {
            background-color: var(--bg3-darker);
            border-top: 2px solid var(--bg3-border);
            color: #89a8c5;
        }
        .sidebar-card { background-color: var(--bg3-card); border: 1px solid var(--bg3-border); border-radius: 8px; padding: 1.25rem; }
        .text-gold { color: var(--bg3-gold) !important; }
        .form-control, .form-select {
            background-color: #10283b;
            border-color: var(--bg3-border);
            color: #d8ebff;
        }
        .form-control::placeholder,
        textarea.form-control::placeholder {
            color: #a8c9e8;
            opacity: 1;
        }
        .form-control:focus, .form-select:focus {
            background-color: #10283b;
            border-color: var(--bg3-gold);
            color: #d8ebff;
            box-shadow: 0 0 0 .25rem rgba(103,232,249,.25);
        }
        .page-link { background-color: var(--bg3-card); border-color: var(--bg3-border); color: #d8ebff; }
        .page-link:hover { background-color: var(--bg3-gold); color: var(--bg3-dark); }
        .page-item.active .page-link { background-color: var(--bg3-gold); border-color: var(--bg3-gold); color: var(--bg3-dark); }
        .table-dark-bg { background-color: var(--bg3-card); color: #d8ebff; }
        .table-dark-bg th { background-color: #071421; color: var(--bg3-gold); border-color: var(--bg3-border); }
        .table-dark-bg td { border-color: var(--bg3-border); }
        .alert-success { background-color: #0f3137; border-color: #1f5a64; color: #8ee5f2; }
        .alert-danger  { background-color: #3a121f; border-color: #6b2b40; color: #f4a0b7; }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="bi bi-shield-fill-check me-2"></i>BG3 Guide
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('guides.index') }}">Guides</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Categories</a>
                        <ul class="dropdown-menu" style="background-color:var(--bg3-card); border-color:var(--bg3-border);">
                            @foreach(\App\Models\Category::all() as $cat)
                                    <li><a class="dropdown-item" style="color:#d8ebff;"
                                       href="{{ route('guides.index', ['category' => $cat->slug]) }}">
                                    {{ $cat->icon ? $cat->icon . ' ' : '' }}{{ $cat->name }}
                                </a></li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
                <form class="d-flex me-3" action="{{ route('guides.index') }}" method="GET">
                    <input class="form-control form-control-sm me-2" type="search" name="search"
                           placeholder="Search guides…" value="{{ request('search') }}">
                    <button class="btn btn-gold btn-sm" type="submit"><i class="bi bi-search"></i></button>
                </form>
                <ul class="navbar-nav">
                    @auth
                        @if(auth()->user()->isEditor())
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-1"></i>Admin</a></li>
                        @endif
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" style="background-color:var(--bg3-card); border-color:var(--bg3-border);">
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button class="dropdown-item" style="color:#d8ebff;" type="submit">
                                            <i class="bi bi-box-arrow-right me-1"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        <li class="nav-item"><a class="nav-link btn btn-gold btn-sm ms-2 px-3" href="{{ route('register') }}">Register</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @if(session('success'))
            <div class="container mt-3">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif
        @yield('content')
    </main>

    <footer class="mt-5 py-4">
        <div class="container text-center">
            <p class="mb-1"><strong class="text-gold">BG3 Guide</strong> — A community guide for Baldur's Gate 3</p>
            <small>Created by Marius and Gvidonas. Baldur's Gate 3 is owned by Larian Studios.</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
