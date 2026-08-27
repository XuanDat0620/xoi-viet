@extends('layouts.app')

@section('title', 'Danh sách sản phẩm - Xôi Việt')

@section('content')
<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active">Sản phẩm</li>
        </ol>
    </nav>

    <div class="row">
        {{-- ===== BỘ LỌC SẢN PHẨM ===== --}}
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3 mb-4" style="border-radius: 16px;">
                <h6 class="fw-bold mb-3">Bộ lọc sản phẩm</h6>
                <form method="GET" action="{{ route('products.index') }}">
                    <input type="hidden" name="q" value="{{ request('q') }}">

                    <label class="form-label fw-semibold small">Danh mục</label>
                    <select name="category" class="form-select form-select-sm mb-3" onchange="this.form.submit()">
                        <option value="">Tất cả danh mục</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>

                    <label class="form-label fw-semibold small">Khoảng giá</label>
                    <div class="d-flex gap-2 mb-3">
                        <input type="number" name="price_min" placeholder="Từ" class="form-control form-control-sm" value="{{ request('price_min') }}">
                        <input type="number" name="price_max" placeholder="Đến" class="form-control form-control-sm" value="{{ request('price_max') }}">
                    </div>

                    <label class="form-label fw-semibold small">Sắp xếp theo</label>
                    <select name="sort" class="form-select form-select-sm mb-3" onchange="this.form.submit()">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Hàng mới về</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá thấp đến cao</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá cao đến thấp</option>
                        <option value="bestseller" {{ request('sort') == 'bestseller' ? 'selected' : '' }}>Bán chạy nhất</option>
                    </select>

                    <button type="submit" class="btn btn-warning btn-sm w-100 fw-semibold text-white">Lọc kết quả</button>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm w-100 mt-2">Xoá bộ lọc</a>
                </form>
            </div>
        </div>

        {{-- ===== DANH SÁCH SẢN PHẨM ===== --}}
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">
                    @if(request('q'))
                        Kết quả tìm kiếm cho "{{ request('q') }}"
                    @else
                        Tất cả sản phẩm
                    @endif
                </h5>
                <span class="text-muted small">{{ $products->total() }} sản phẩm</span>
            </div>

            <div class="row g-4">
                @forelse($products as $product)
                    <div class="col-6 col-md-4">
                        @include('components.product-card', ['product' => $product])
                    </div>
                @empty
                    <div class="col-12 text-center py-5 text-muted">
                        <i class="bi bi-emoji-frown fs-1"></i>
                        <p class="mt-2">Không tìm thấy sản phẩm phù hợp.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
