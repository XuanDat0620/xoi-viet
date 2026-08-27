<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- ===== CHUẨN SEO: title & meta description theo từng trang ===== --}}
    <title>@yield('title', 'Xôi Việt - Món ngon truyền thống mỗi ngày')</title>
    <meta name="description" content="@yield('meta_description', 'Đặt mua xôi xéo, xôi gấc, xôi lạc, xôi mặn thập cẩm chuẩn vị truyền thống, giao hàng tận nơi nhanh chóng.')">
    <link rel="icon" href="https://em-content.zobj.net/source/apple/354/cooked-rice_1f35a.png">

    {{-- Bootstrap 5 + Icons qua CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    @stack('styles')
</head>
<body>

{{-- ============ HEADER ============ --}}
<header class="site-header sticky-top">
    <div class="container">
        <nav class="navbar navbar-expand-lg py-2">
            <a class="navbar-brand fw-bold fs-3 text-warning" href="{{ route('home') }}">
                🍚 Xôi <span class="text-dark">Việt</span>
            </a>

            {{-- Ô tìm kiếm sản phẩm --}}
            <form action="{{ route('products.search') }}" method="GET" class="d-none d-md-flex mx-auto" style="width: 40%;">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Tìm món xôi bạn thích..." value="{{ request('q') }}">
                    <button class="btn btn-warning" type="submit"><i class="bi bi-search"></i></button>
                </div>
            </form>

            <div class="d-flex align-items-center gap-3">
                {{-- Giỏ hàng --}}
                <a href="{{ route('cart.index') }}" class="btn btn-outline-dark position-relative">
                    <i class="bi bi-cart3"></i>
                    @php $cartCount = collect(session('cart', []))->sum('qty'); @endphp
                    @if($cartCount > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                {{-- Tài khoản --}}
                @auth
                    <div class="dropdown">
                        <button class="btn btn-warning dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> {{ Str::limit(auth()->user()->name, 12) }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('orders.myOrders') }}">Đơn hàng của tôi</a></li>
                            @if(auth()->user()->isAdmin())
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Trang quản trị</a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item text-danger">Đăng xuất</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-warning fw-semibold">Đăng nhập</a>
                @endauth
            </div>
        </nav>

        {{-- Menu danh mục --}}
        <ul class="nav category-nav justify-content-center flex-wrap border-top py-2">
            <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Trang chủ</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">Tất cả sản phẩm</a></li>
            @foreach(\App\Models\Category::where('is_active', true)->get() as $cat)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('products.index', ['category' => $cat->slug]) }}">{{ $cat->name }}</a>
                </li>
            @endforeach
            <li class="nav-item"><a class="nav-link" href="{{ route('blog.index') }}">Tin tức</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('contact.index') }}">Liên hệ</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('orders.trackForm') }}">Tra cứu đơn hàng</a></li>
        </ul>
    </div>
</header>

{{-- ============ THÔNG BÁO ============ --}}
<div class="container mt-3">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
</div>

{{-- ============ NỘI DUNG TRANG ============ --}}
<main>
    @yield('content')
</main>

{{-- ============ FOOTER ============ --}}
<footer class="site-footer mt-5 pt-5 pb-3">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <h5 class="text-warning fw-bold">🍚 Xôi Việt</h5>
                <p class="text-light-emphasis">Món xôi truyền thống Việt Nam - thơm ngon chuẩn vị, giao hàng tận nơi mỗi ngày.</p>
            </div>
            <div class="col-md-2">
                <h6 class="text-white">Danh mục</h6>
                <ul class="list-unstyled">
                    @foreach(\App\Models\Category::where('is_active', true)->get() as $cat)
                        <li><a href="{{ route('products.index', ['category' => $cat->slug]) }}">{{ $cat->name }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-3">
                <h6 class="text-white">Hỗ trợ khách hàng</h6>
                <ul class="list-unstyled">
                    <li><a href="{{ route('orders.trackForm') }}">Tra cứu đơn hàng</a></li>
                    <li><a href="{{ route('contact.index') }}">Liên hệ</a></li>
                    <li><a href="{{ route('blog.index') }}">Tin tức - Blog</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h6 class="text-white">Liên hệ</h6>
                <ul class="list-unstyled text-light-emphasis">
                    <li><i class="bi bi-telephone-fill me-2"></i>Hotline: 1900 6868</li>
                    <li><i class="bi bi-envelope-fill me-2"></i>cskh@xoiviet.vn</li>
                    <li><i class="bi bi-geo-alt-fill me-2"></i>123 Đường Ẩm Thực, Q.1, TP.HCM</li>
                </ul>
            </div>
        </div>
        <hr class="border-secondary">
        <p class="text-center text-light-emphasis mb-0">&copy; {{ date('Y') }} Xôi Việt. Sản phẩm dự thi BKACAD Challenge: Web Design Innovation 2026.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
