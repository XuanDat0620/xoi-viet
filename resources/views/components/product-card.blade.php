{{-- Component: Thẻ hiển thị 1 sản phẩm - dùng chung cho Trang chủ & Trang danh mục --}}
<div class="product-card position-relative">
    <a href="{{ route('products.show', $product->slug) }}">
        @if($product->discount_percent > 0)
            <span class="badge badge-discount">-{{ $product->discount_percent }}%</span>
        @endif
        <img src="{{ $product->thumbnail ? asset('storage/'.$product->thumbnail) : 'https://placehold.co/300x200/A3242A/fff?text=Xoi+Viet' }}" alt="{{ $product->name }}">
    </a>
    <div class="p-3">
        <small class="text-muted">{{ $product->category->name ?? '' }}</small>
        <h6 class="fw-semibold mt-1 mb-2">
            <a href="{{ route('products.show', $product->slug) }}" class="text-dark text-decoration-none">
                {{ Str::limit($product->name, 40) }}
            </a>
        </h6>
        <div class="d-flex align-items-center gap-2 mb-2">
            <span class="price-new">{{ number_format($product->price) }}đ</span>
            @if($product->original_price)
                <span class="price-old">{{ number_format($product->original_price) }}đ</span>
            @endif
        </div>
        <div class="d-flex justify-content-between align-items-center">
            <small class="text-muted"><i class="bi bi-star-fill text-warning"></i> {{ $product->rating }} · Đã bán {{ $product->sold_count }}</small>
        </div>
        <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-2">
            @csrf
            <button type="submit" class="btn btn-warning btn-sm w-100 fw-semibold text-white">
                <i class="bi bi-cart-plus"></i> Thêm vào giỏ
            </button>
        </form>
    </div>
</div>
