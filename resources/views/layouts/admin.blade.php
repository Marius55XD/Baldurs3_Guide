<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin — @yield('title', 'Dashboard') | BG3 Guide</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root { --bg3-gold: #67e8f9; --bg3-dark: #061522; --bg3-darker: #030c14; --bg3-card: #0b2233; --bg3-border: #1e3a53; }
        body { background-color: #05121d; color: #d8ebff; }
        .sidebar { width: 240px; min-height: 100vh; background-color: var(--bg3-darker); border-right: 2px solid var(--bg3-border); position: fixed; top: 0; left: 0; z-index: 100; }
        .sidebar .brand { padding: 1.25rem; border-bottom: 1px solid var(--bg3-border); }
        .sidebar .brand a { color: var(--bg3-gold); font-weight: 700; text-decoration: none; font-size: 1.2rem; }
        .sidebar .nav-link { color: #a9c8e8; padding: .6rem 1.25rem; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { color: var(--bg3-gold); background-color: #10283b; }
        .sidebar .nav-link i { width: 1.4rem; }
        .main-content { margin-left: 240px; padding: 2rem; }
        .admin-topbar { background-color: var(--bg3-darker); border-bottom: 1px solid var(--bg3-border); padding: .75rem 2rem; margin-left: 240px; position: sticky; top: 0; z-index: 50; }
        .bg3-card { background-color: var(--bg3-card); border: 1px solid var(--bg3-border); border-radius: 8px; }
        .btn-gold { background-color: var(--bg3-gold); color: var(--bg3-dark); border: none; font-weight: 600; }
        .btn-gold:hover { background-color: #a5f3fc; color: var(--bg3-dark); }
        .btn-outline-gold {
            border-color: var(--bg3-gold);
            color: var(--bg3-gold);
        }
        .btn-outline-gold:hover,
        .btn-outline-gold:focus {
            background-color: var(--bg3-gold);
            border-color: var(--bg3-gold);
            color: var(--bg3-dark);
        }
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
        .table-dark-bg { background-color: #f3f8ff; color: #000; }
        .table-dark-bg th { background-color: #e2ebf8; color: #000; border-color: #b6c7dc; }
        .table-dark-bg td { border-color: #b6c7dc; background-color: #f9fcff; color: #000; }
        .table-dark-bg a,
        .table-dark-bg small,
        .table-dark-bg code {
            color: #000 !important;
        }
        .stat-card { background-color: var(--bg3-card); border: 1px solid var(--bg3-border); border-radius: 8px; padding: 1.5rem; }
        .stat-card .stat-value { font-size: 2rem; font-weight: 700; color: var(--bg3-gold); }
        .form-control, .form-select, textarea {
            background-color: #10283b; border-color: var(--bg3-border); color: #d8ebff;
        }
        .form-control::placeholder,
        textarea.form-control::placeholder {
            color: #a8c9e8;
            opacity: 1;
        }
        .form-control:focus, .form-select:focus, textarea:focus {
            background-color: #10283b; border-color: var(--bg3-gold); color: #d8ebff;
            box-shadow: 0 0 0 .25rem rgba(103,232,249,.25);
        }
        .alert-success { background-color: #0f3137; border-color: #1f5a64; color: #8ee5f2; }
        .alert-danger  { background-color: #3a121f; border-color: #6b2b40; color: #f4a0b7; }
        .page-link { background-color: var(--bg3-card); border-color: var(--bg3-border); color: #d8ebff; }
        .page-link:hover { background-color: var(--bg3-gold); color: var(--bg3-dark); }
        .page-item.active .page-link { background-color: var(--bg3-gold); border-color: var(--bg3-gold); color: var(--bg3-dark); }
        .text-gold { color: var(--bg3-gold) !important; }
    </style>
</head>
<body>
    <div class="sidebar d-flex flex-column">
        <div class="brand">
            <a href="{{ route('admin.dashboard') }}"><i class="bi bi-shield-fill-check me-2"></i>BG3 Admin</a>
        </div>
        <nav class="mt-2 flex-grow-1">
            <a href="{{ route('admin.dashboard') }}" class="nav-link @if(request()->routeIs('admin.dashboard')) active @endif">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('admin.guides.index') }}" class="nav-link @if(request()->routeIs('admin.guides.*')) active @endif">
                <i class="bi bi-book"></i> Guides
            </a>
            <a href="{{ route('admin.categories.index') }}" class="nav-link @if(request()->routeIs('admin.categories.*')) active @endif">
                <i class="bi bi-tags"></i> Categories
            </a>
            <hr style="border-color: var(--bg3-border); margin: .5rem 1.25rem;">
            <a href="{{ url('/') }}" class="nav-link"><i class="bi bi-house"></i> View Site</a>
        </nav>
        <div class="p-3" style="border-top:1px solid var(--bg3-border); font-size:.85rem;">
            <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}
            <form action="{{ route('logout') }}" method="POST" class="mt-1">
                @csrf
                <button class="btn btn-sm btn-outline-secondary w-100" type="submit">Logout</button>
            </form>
        </div>
    </div>

    <div style="margin-left:240px;">
        <div class="admin-topbar d-flex align-items-center" style="margin-left:0;">
            <h5 class="mb-0 text-gold">@yield('title', 'Dashboard')</h5>
            @if(session('success'))
                <div class="alert alert-success py-1 px-3 mb-0 ms-3">
                    <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
                </div>
            @endif
        </div>
        <div class="main-content" style="margin-left:0;">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
