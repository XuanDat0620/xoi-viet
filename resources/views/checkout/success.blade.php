@extends('layouts.app')

@section('title', 'Đặt hàng thành công - Xôi Việt')

@section('content')
<div class="container mt-5 mb-5 text-center">
    <i class="bi bi-check-circle-fill text-success" style="font-size: 70px;"></i>
    <h1 class="fw-bold h3 mt-3">Đặt hàng thành công!</h1>
    <p class="text-muted">Cảm ơn bạn đã đặt xôi tại Xôi Việt. Chúng tôi sẽ liên hệ xác nhận đơn hàng sớm nhất.</p>

    <div class="card border-0 shadow-sm mx-auto mt-4 p-4 text-start" style="max-width: 500px; border-radius: 16px;">
        <p class="mb-2"><strong>Mã đơn hàng:</strong> <span class="text-danger fw-bold">{{ $order->order_code }}</span></p>
        <p class="mb-2"><strong>Người nhận:</strong> {{ $order->customer_name }}</p>
        <p class="mb-2"><strong>Điện thoại:</strong> {{ $order->customer_phone }}</p>
        <p class="mb-2"><strong>Địa chỉ:</strong> {{ $order->shipping_address }}</p>
        <p class="mb-2"><strong>Tổng tiền:</strong> {{ number_format($order->total) }}đ</p>
        <p class="mb-0"><strong>Trạng thái:</strong> <span class="badge bg-warning text-white">{{ $order->status_label }}</span></p>
    </div>

    <p class="text-muted mt-3 small">Vui lòng lưu lại mã đơn hàng để tra cứu trạng thái giao hàng bất cứ lúc nào.</p>

    <div class="mt-3">
        <a href="{{ route('orders.trackForm') }}" class="btn btn-outline-warning me-2">Tra cứu đơn hàng</a>
        <a href="{{ route('products.index') }}" class="btn btn-warning text-white">Tiếp tục mua sắm</a>
    </div>
</div>
@endsection
