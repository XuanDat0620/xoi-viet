@extends('layouts.app')

@section('title', 'Tra cứu đơn hàng - Xôi Việt')

@section('content')
<div class="container mt-4 mb-5">
    <h1 class="fw-bold h3 mb-4"><i class="bi bi-search"></i> Tra cứu đơn hàng</h1>

    <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius: 16px; max-width: 600px;">
        <form action="{{ route('orders.track') }}" method="POST" class="row g-3">
            @csrf
            <div class="col-md-6">
                <label class="form-label">Mã đơn hàng</label>
                <input type="text" name="order_code" class="form-control" placeholder="VD: XV260820AB12" required value="{{ old('order_code') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Số điện thoại đặt hàng</label>
                <input type="text" name="customer_phone" class="form-control" required value="{{ old('customer_phone') }}">
            </div>
            <div class="col-12">
                <button class="btn btn-warning fw-semibold text-white">Tra cứu</button>
            </div>
        </form>
    </div>

    @isset($order)
        <div class="card border-0 shadow-sm p-4" style="border-radius: 16px;">
            <h6 class="fw-bold">Đơn hàng #{{ $order->order_code }}</h6>

            {{-- ===== TIẾN TRÌNH TRẠNG THÁI ĐƠN HÀNG ===== --}}
            @php
                $steps = ['pending' => 'Chờ xác nhận', 'confirmed' => 'Đã xác nhận', 'shipping' => 'Đang giao', 'completed' => 'Hoàn tất'];
                $statusOrder = array_keys($steps);
                $currentIndex = array_search($order->status, $statusOrder);
            @endphp

            @if($order->status === 'cancelled')
                <div class="alert alert-danger">Đơn hàng này đã bị huỷ.</div>
            @else
                <div class="d-flex justify-content-between my-4">
                    @foreach($steps as $key => $label)
                        @php
                            $index = array_search($key, $statusOrder);
                            $class = $index < $currentIndex ? 'done' : ($index === $currentIndex ? 'active' : '');
                        @endphp
                        <div class="status-step {{ $class }}">
                            <div class="circle">{{ $index + 1 }}</div>
                            <small>{{ $label }}</small>
                        </div>
                    @endforeach
                </div>
            @endif

            <hr>
            <p><strong>Người nhận:</strong> {{ $order->customer_name }} - {{ $order->customer_phone }}</p>
            <p><strong>Địa chỉ:</strong> {{ $order->shipping_address }}</p>

            <table class="table table-sm mt-3">
                <thead><tr><th>Sản phẩm</th><th>SL</th><th>Thành tiền</th></tr></thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product_name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->line_total) }}đ</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="text-end fw-bold fs-5">Tổng cộng: <span class="text-danger">{{ number_format($order->total) }}đ</span></div>
        </div>
    @endisset
</div>
@endsection
