@extends('layouts.app')

@section('title', 'Xôi Việt - Đặt xôi truyền thống ngon mỗi ngày')

@section('content')

{{-- ===== HERO BANNER ===== --}}
<div class="container mt-4">
    <div class="hero-banner position-relative overflow-hidden">
        <div class="hero-shape hero-shape-1"></div>
        <div class="hero-shape hero-shape-2"></div>
        <div class="row align-items-center position-relative">
            <div class="col-md-7">
                <span class="hero-badge"><i class="bi bi-lightning-fill"></i> Giao trong 30 phút</span>
                <h1 class="fw-800 display-5 fw-bold mt-3 mb-3">Xôi truyền thống<br>chuẩn vị Hà Nội</h1>
                <p class="fs-5 mb-4">Xôi xéo, xôi gấc, xôi mặn thập cẩm... nấu mỗi sáng từ gạo nếp cái hoa vàng, giao tận nơi khi còn nóng hổi.</p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('products.index') }}" class="btn btn-light btn-lg fw-semibold text-warning shadow">
                        Đặt mua ngay <i class="bi bi-arrow-right"></i>
                    </a>
                    <a href="#why-us" class="btn btn-outline-light btn-lg fw-semibold">
                        Vì sao chọn chúng tôi?
                    </a>
                </div>
                <div class="d-flex align-items-center gap-2 mt-4">
                    <div class="d-flex">
                        <span class="avatar-dot">👩</span><span class="avatar-dot">🧑</span><span class="avatar-dot">👨</span>
                    </div>
                    <small>Hơn <strong>5.000+</strong> khách hàng hài lòng</small>
                </div>
            </div>
            <div class="col-md-5 text-center d-none d-md-block">
                <div class="hero-emoji-wrap">
                    <span class="hero-emoji">🍚</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== THANH SỐ LIỆU ẤN TƯỢNG ===== --}}
<div class="container mt-4">
    <div class="stats-bar row text-center g-3">
        <div class="col-6 col-md-3">
            <div class="stat-item">
                <div class="stat-number">10+</div>
                <small>Năm kinh nghiệm</small>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-item">
                <div class="stat-number">5.000+</div>
                <small>Khách hàng thân thiết</small>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-item">
                <div class="stat-number">4.8/5</div>
                <small><i class="bi bi-star-fill text-warning"></i> Đánh giá trung bình</small>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-item">
                <div class="stat-number">30 phút</div>
                <small>Giao hàng nhanh</small>
            </div>
        </div>
    </div>
</div>

{{-- ===== VÌ SAO CHỌN CHÚNG TÔI ===== --}}
<div class="container mt-5" id="why-us">
    <h2 class="section-title mx-auto text-center d-block">Vì sao chọn Xôi Việt?</h2>
    <div class="row g-4 mt-2">
        <div class="col-6 col-md-3">
            <div class="why-item text-center">
                <div class="why-icon">🌾</div>
                <h6 class="fw-bold mt-3">Nguyên liệu tươi sạch</h6>
                <p class="text-muted small">Gạo nếp cái hoa vàng chọn lọc, đồ chín mỗi sáng bằng hơi nước truyền thống.</p>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="why-item text-center">
                <div class="why-icon">🛵</div>
                <h6 class="fw-bold mt-3">Giao hàng nhanh chóng</h6>
                <p class="text-muted small">Đặt hàng và nhận xôi nóng hổi trong vòng 30 phút tại nội thành.</p>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="why-item text-center">
                <div class="why-icon">💰</div>
                <h6 class="fw-bold mt-3">Giá cả hợp lý</h6>
                <p class="text-muted small">Chất lượng cao cấp với mức giá bình dân, phù hợp mọi bữa ăn hằng ngày.</p>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="why-item text-center">
                <div class="why-icon">👵</div>
                <h6 class="fw-bold mt-3">Công thức gia truyền</h6>
                <p class="text-muted small">Hương vị nấu theo bí quyết 3 đời, giữ trọn nét truyền thống Hà Nội xưa.</p>
            </div>
        </div>
    </div>
</div>

{{-- ===== DANH MỤC ===== --}}
<div class="container mt-5">
    <h2 class="section-title">Danh mục sản phẩm</h2>
    <div class="row g-3">
        @foreach($categories as $cat)
            <div class="col-6 col-md-3">
                <a href="{{ route('products.index', ['category' => $cat->slug]) }}" class="text-decoration-none">
                    <div class="category-card text-center h-100">
                        <div class="category-icon">🍚</div>
                        <div class="fw-semibold text-dark mt-2">{{ $cat->name }}</div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>

{{-- ===== SẢN PHẨM NỔI BẬT ===== --}}
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h2 class="section-title">Món xôi nổi bật</h2>
        <a href="{{ route('products.index') }}" class="text-warning fw-semibold text-decoration-none mb-3">Xem tất cả <i class="bi bi-arrow-right"></i></a>
    </div>
    <div class="row g-4">
        @forelse($featuredProducts as $product)
            <div class="col-6 col-md-3">
                @include('components.product-card', ['product' => $product])
            </div>
        @empty
            <p class="text-muted">Chưa có sản phẩm nổi bật. Hãy thêm sản phẩm ở trang quản trị.</p>
        @endforelse
    </div>
</div>

{{-- ===== BÁN CHẠY NHẤT ===== --}}
<div class="container mt-5">
    <h2 class="section-title">Bán chạy nhất tuần này 🔥</h2>
    <div class="row g-4">
        @foreach($bestSellers as $product)
            <div class="col-6 col-md-3">
                @include('components.product-card', ['product' => $product])
            </div>
        @endforeach
    </div>
</div>

{{-- ===== ĐÁNH GIÁ KHÁCH HÀNG ===== --}}
<div class="container mt-5">
    <h2 class="section-title mx-auto text-center d-block">Khách hàng nói gì về chúng tôi</h2>
    <div class="row g-4 mt-2">
        <div class="col-md-4">
            <div class="testimonial-card">
                <div class="text-warning mb-2">★★★★★</div>
                <p class="fst-italic">"Xôi xéo ở đây đúng chuẩn vị Hà Nội, đậu xanh mịn, hành phi giòn thơm. Giao hàng cũng rất nhanh!"</p>
                <div class="d-flex align-items-center gap-2 mt-3">
                    <span class="avatar-dot">👩</span>
                    <div>
                        <div class="fw-semibold">Chị Lan Anh</div>
                        <small class="text-muted">Quận 1, TP.HCM</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="testimonial-card">
                <div class="text-warning mb-2">★★★★★</div>
                <p class="fst-italic">"Đặt xôi mặn thập cẩm cho cả gia đình ăn sáng, phần ăn đầy đặn, đóng gói sạch sẽ, giá lại hợp lý."</p>
                <div class="d-flex align-items-center gap-2 mt-3">
                    <span class="avatar-dot">🧑</span>
                    <div>
                        <div class="fw-semibold">Anh Minh Quân</div>
                        <small class="text-muted">Quận 3, TP.HCM</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="testimonial-card">
                <div class="text-warning mb-2">★★★★★</div>
                <p class="fst-italic">"Xôi gấc màu đỏ đẹp mắt, dẻo thơm, mình hay đặt vào dịp lễ Tết biếu ông bà. Rất ưng ý!"</p>
                <div class="d-flex align-items-center gap-2 mt-3">
                    <span class="avatar-dot">👨</span>
                    <div>
                        <div class="fw-semibold">Chú Hoàng Nam</div>
                        <small class="text-muted">Quận Bình Thạnh, TP.HCM</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== TIN TỨC MỚI ===== --}}
@if($latestPosts->count())
<div class="container mt-5">
    <h2 class="section-title">Tin tức & mẹo vặt nhà bếp</h2>
    <div class="row g-4">
        @foreach($latestPosts as $post)
            <div class="col-md-4">
                <a href="{{ route('blog.show', $post->slug) }}" class="text-decoration-none text-dark">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                        <div class="card-body">
                            <h5 class="fw-bold">{{ $post->title }}</h5>
                            <p class="text-muted">{{ Str::limit($post->excerpt, 100) }}</p>
                            <span class="text-warning fw-semibold">Đọc thêm →</span>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
@endif

{{-- ===== CTA CUỐI TRANG ===== --}}
<div class="container mt-5 mb-5">
    <div class="cta-banner text-center">
        <h3 class="fw-bold mb-2">Đói bụng chưa? Đặt xôi ngay thôi! 🍚</h3>
        <p class="mb-4">Chỉ mất 2 phút để đặt hàng, xôi nóng hổi sẽ đến tay bạn trong 30 phút.</p>
        <a href="{{ route('products.index') }}" class="btn btn-warning btn-lg fw-semibold text-white px-5">Đặt hàng ngay</a>
    </div>
</div>

@endsection
