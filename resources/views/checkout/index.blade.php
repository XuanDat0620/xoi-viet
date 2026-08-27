@extends('layouts.app')

@section('title', 'Thanh toán đơn hàng - Xôi Việt')

@section('content')
<div class="container mt-4">
    <h1 class="fw-bold h3 mb-4"><i class="bi bi-credit-card"></i> Thanh toán</h1>

    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf
        <div class="row g-4">
            {{-- ===== THÔNG TIN NGƯỜI MUA ===== --}}
            <div class="col-md-7">
                <div class="card border-0 shadow-sm p-4" style="border-radius: 16px;">
                    <h6 class="fw-bold mb-3">Thông tin nhận hàng</h6>

                    <div class="mb-3">
                        <label class="form-label">Họ và tên <span class="text-danger">*</span></label>
                        <input type="text" name="customer_name" class="form-control @error('customer_name') is-invalid @enderror"
                               value="{{ old('customer_name', auth()->user()->name ?? '') }}" required>
                        @error('customer_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="text" name="customer_phone" class="form-control @error('customer_phone') is-invalid @enderror"
                                   value="{{ old('customer_phone', auth()->user()->phone ?? '') }}" required>
                            @error('customer_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email (không bắt buộc)</label>
                            <input type="email" name="customer_email" class="form-control" value="{{ old('customer_email', auth()->user()->email ?? '') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Địa chỉ nhận hàng <span class="text-danger">*</span></label>
                        <textarea name="shipping_address" class="form-control @error('shipping_address') is-invalid @enderror" rows="2" required>{{ old('shipping_address') }}</textarea>
                        @error('shipping_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ghi chú đơn hàng</label>
                        <textarea name="note" class="form-control" rows="2" placeholder="Ví dụ: giao giờ hành chính, ít cay..."></textarea>
                    </div>

                    <h6 class="fw-bold mt-3 mb-3">Phương thức thanh toán</h6>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="payment_method" value="cod" id="cod" checked>
                        <label class="form-check-label" for="cod"><i class="bi bi-cash-coin"></i> Thanh toán khi nhận hàng (COD)</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="payment_method" value="bank_transfer" id="bank">
                        <label class="form-check-label" for="bank"><i class="bi bi-bank"></i> Chuyển khoản ngân hàng</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="payment_method" value="momo" id="momo">
                        <label class="form-check-label" for="momo"><i class="bi bi-phone"></i> Ví MoMo</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_method" value="vnpay" id="vnpay">
                        <label class="form-check-label" for="vnpay"><i class="bi bi-credit-card-2-front"></i> VNPay</label>
                    </div>
                </div>
            </div>

            {{-- ===== TÓM TẮT ĐƠN HÀNG ===== --}}
            <div class="col-md-5">
                <div class="card border-0 shadow-sm p-4" style="border-radius: 16px;">
                    <h6 class="fw-bold mb-3">Đơn hàng của bạn</h6>
                    <ul class="list-group list-group-flush mb-3">
                        @foreach($cart as $item)
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span>{{ $item['name'] }} x{{ $item['qty'] }}</span>
                                <span>{{ number_format($item['price'] * $item['qty']) }}đ</span>
                            </li>
                        @endforeach
                    </ul>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tạm tính</span><span>{{ number_format($subtotal) }}đ</span>
                    </div>
                    @if($discount > 0)
                    <div class="d-flex justify-content-between mb-2 text-success">
                        <span>Giảm giá</span><span>-{{ number_format($discount) }}đ</span>
                    </div>
                    @endif
                    <div class="d-flex justify-content-between mb-2">
                        <span>Phí vận chuyển</span><span>15.000đ</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold fs-5 mb-3">
                        <span>Tổng cộng</span><span class="text-danger">{{ number_format($total) }}đ</span>
                    </div>
                    <button type="submit" class="btn btn-warning fw-semibold text-white w-100 py-2">
                        Đặt hàng ngay
                    </button>
                    <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary w-100 mt-2">Quay lại giỏ hàng</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
