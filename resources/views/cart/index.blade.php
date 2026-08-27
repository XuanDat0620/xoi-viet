@extends('layouts.app')

@section('title', 'Giỏ hàng của bạn - Xôi Việt')

@section('content')
<div class="container mt-4">
    <h1 class="fw-bold h3 mb-4"><i class="bi bi-cart3"></i> Giỏ hàng của bạn</h1>

    @if(empty($cart))
        <div class="text-center py-5">
            <i class="bi bi-cart-x fs-1 text-muted"></i>
            <p class="text-muted mt-2">Giỏ hàng của bạn đang trống.</p>
            <a href="{{ route('products.index') }}" class="btn btn-warning fw-semibold text-white">Tiếp tục mua sắm</a>
        </div>
    @else
    <div class="row g-4">
        {{-- ===== DANH SÁCH SẢN PHẨM ĐÃ CHỌN ===== --}}
        <div class="col-md-8">
            <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Đơn giá</th>
                                <th style="width: 140px;">Số lượng</th>
                                <th>Thành tiền</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart as $productId => $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <img src="{{ $item['thumbnail'] ? asset('storage/'.$item['thumbnail']) : 'https://placehold.co/60x60/A3242A/fff?text=Xoi' }}" width="55" height="55" style="object-fit:cover; border-radius:8px;">
                                            <span class="fw-semibold">{{ $item['name'] }}</span>
                                        </div>
                                    </td>
                                    <td>{{ number_format($item['price']) }}đ</td>
                                    <td>
                                        <form action="{{ route('cart.update', $productId) }}" method="POST" class="d-flex">
                                            @csrf @method('PATCH')
                                            <input type="number" name="qty" value="{{ $item['qty'] }}" min="1" class="form-control form-control-sm" onchange="this.form.submit()">
                                        </form>
                                    </td>
                                    <td class="fw-semibold text-danger">{{ number_format($item['price'] * $item['qty']) }}đ</td>
                                    <td>
                                        <form action="{{ route('cart.remove', $productId) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ===== TÓM TẮT ĐƠN HÀNG + MÃ GIẢM GIÁ ===== --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3" style="border-radius: 16px;">
                <h6 class="fw-bold mb-3">Tóm tắt đơn hàng</h6>

                {{-- Ô nhập mã giảm giá --}}
                <form action="{{ route('cart.coupon') }}" method="POST" class="d-flex gap-2 mb-3">
                    @csrf
                    <input type="text" name="code" class="form-control form-control-sm" placeholder="Nhập mã giảm giá" value="{{ $coupon['code'] ?? '' }}">
                    <button class="btn btn-sm btn-outline-warning">Áp dụng</button>
                </form>

                <div class="d-flex justify-content-between mb-2">
                    <span>Tạm tính</span>
                    <span>{{ number_format($subtotal) }}đ</span>
                </div>
                @if($discount > 0)
                <div class="d-flex justify-content-between mb-2 text-success">
                    <span>Giảm giá ({{ $coupon['code'] }})</span>
                    <span>-{{ number_format($discount) }}đ</span>
                </div>
                @endif
                <hr>
                <div class="d-flex justify-content-between fw-bold fs-5">
                    <span>Tổng tạm tính</span>
                    <span class="text-danger">{{ number_format($subtotal - $discount) }}đ</span>
                </div>
                <small class="text-muted">(Phí vận chuyển sẽ được tính ở bước thanh toán)</small>

                <a href="{{ route('checkout.index') }}" class="btn btn-warning fw-semibold text-white w-100 mt-3">
                    Tiến hành thanh toán <i class="bi bi-arrow-right"></i>
                </a>
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary w-100 mt-2">Tiếp tục mua sắm</a>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
