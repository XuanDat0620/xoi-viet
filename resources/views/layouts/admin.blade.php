<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Quản trị') - Xôi Việt Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>body { font-family: 'Be Vietnam Pro', sans-serif; background: #fdf6ec; }</style>
    @stack('styles')
</head>
<body>
<div class="d-flex">
    {{-- ===== SIDEBAR ===== --}}
    <div class="admin-sidebar text-white" style="width: 250px; flex-shrink: 0;">
        <div class="p-3 border-bottom border-secondary">
            <a href="{{ route('admin.dashboard') }}" class="text-white fw-bold fs-5 text-decoration-none">🍚 Xôi Việt Admin</a>
        </div>
        <nav class="py-3">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 me-2"></i> Tổng quan
            </a>
            <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <i class="bi bi-box-seam me-2"></i> Quản lý sản phẩm
            </a>
            <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <i class="bi bi-receipt me-2"></i> Quản lý đơn hàng
            </a>
            <a href="{{ route('admin.customers.index') }}" class="{{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                <i class="bi bi-people me-2"></i> Quản lý khách hàng
            </a>
            <hr class="border-secondary mx-3">
            <a href="{{ route('home') }}"><i class="bi bi-shop me-2"></i> Xem website</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-link text-decoration-none w-100 text-start" style="color:#e8d9c5; padding: 12px 20px;">
                    <i class="bi bi-box-arrow-right me-2"></i> Đăng xuất
                </button>
            </form>
        </nav>
    </div>

    {{-- ===== NỘI DUNG ===== --}}
    <div class="flex-grow-1">
        <div class="bg-white border-bottom p-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">@yield('page-title', 'Tổng quan')</h5>
            <span class="text-muted">Xin chào, <strong>{{ auth()->user()->name }}</strong></span>
        </div>

        <div class="p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
