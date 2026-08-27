@extends('layouts.app')

@section('title', $product->name . ' - Xôi Việt')
@section('meta_description', Str::limit($product->short_description, 150))

@section('content')
<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Sản phẩm</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-5">
        {{-- ===== HÌNH ẢNH (phóng to/thu nhỏ) ===== --}}
        <div class="col-md-5">
            <div class="card border-0 shadow-sm p-2" style="border-radius: 16px;">
                <img id="mainImage"
                     src="{{ $product->thumbnail ? asset('storage/'.$product->thumbnail) : 'https://placehold.co/500x400/A3242A/fff?text=Xoi+Viet' }}"
                     class="img-fluid rounded-3 mb-2" style="cursor: zoom-in;" onclick="this.classList.toggle('zoomed')">
            </div>
            @if($product->images->count())
                <div class="d-flex gap-2 mt-2 flex-wrap">
                    @foreach($product->images as $img)
                        <img src="{{ asset('storage/'.$img->image_path) }}" width="70" height="70" style="object-fit:cover; border-radius: 8px; cursor:pointer;"
                             onclick="document.getElementById('mainImage').src = this.src">
                    @endforeach
                </div>
            @endif
        </div>

        {{-- ===== THÔNG TIN SẢN PHẨM ===== --}}
        <div class="col-md-7">
            <span class="badge bg-light text-dark border mb-2">{{ $product->category->name ?? '' }}</span>
            <h1 class="fw-bold h3">{{ $product->name }}</h1>

            <div class="d-flex align-items-center gap-2 my-2 text-muted">
                <i class="bi bi-star-fill text-warning"></i> {{ $product->rating }}
                <span>·</span> Đã bán {{ $product->sold_count }} {{ $product->unit }}
            </div>

            <div class="d-flex align-items-center gap-3 my-3">
                <span class="price-new fs-3">{{ number_format($product->price) }}đ</span>
                @if($product->original_price)
                    <span class="price-old fs-5">{{ number_format($product->original_price) }}đ</span>
                    <span class="badge bg-danger">-{{ $product->discount_percent }}%</span>
                @endif
                <span class="text-muted">/ {{ $product->unit }}</span>
            </div>

            <p class="text-muted">{{ $product->short_description }}</p>

            {{-- ===== FORM SỐ LƯỢNG + THÊM GIỎ / MUA NGAY ===== --}}
            <div class="d-flex gap-3 mt-4">
                <form action="{{ route('cart.add', $product) }}" method="POST" class="d-flex gap-2 align-items-center">
                    @csrf
                    <input type="number" name="qty" value="1" min="1" class="form-control" style="width: 80px;">
                    <button type="submit" class="btn btn-outline-warning fw-semibold px-4">
                        <i class="bi bi-cart-plus"></i> Thêm vào giỏ hàng
                    </button>
                </form>
                <form action="{{ route('cart.buyNow', $product) }}" method="POST">
                    @csrf
                    <input type="hidden" name="qty" value="1">
                    <button type="submit" class="btn btn-warning fw-semibold px-4 text-white">Mua ngay</button>
                </form>
            </div>

            <hr class="my-4">
            <h6 class="fw-bold">Mô tả sản phẩm</h6>
            <p style="white-space: pre-line;">{{ $product->description }}</p>
        </div>
    </div>

    {{-- ===== SẢN PHẨM LIÊN QUAN ===== --}}
    @if($relatedProducts->count())
    <div class="mt-5">
        <h2 class="section-title">Có thể bạn cũng thích</h2>
        <div class="row g-4">
            @foreach($relatedProducts as $related)
                <div class="col-6 col-md-3">
                    @include('components.product-card', ['product' => $related])
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

@push('styles')
<style>#mainImage.zoomed { transform: scale(1.6); cursor: zoom-out; transition: 0.3s; }</style>
@endpush
@endsection
