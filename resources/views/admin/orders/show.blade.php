
Show.blade · PHP
@extends('layouts.admin')
 
@section('title', 'Chi tiết đơn hàng')
@section('page-title', 'Đơn hàng #' . $order->order_code)
 
@section('content')
<div class="row g-4">
    <div class="col-md-8">
        <div class="card stat-card p-4">
            <h6 class="fw-bold mb-3">Danh sách sản phẩm</h6>
            <table class="table align-middle">
                <thead class="table-light">
                    <tr><th>Sản phẩm</th><th>Đơn giá</th><th>SL</th><th>Thành tiền</th></tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product_name }}</td>
                            <td>{{ number_format($item->price) }}đ</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->line_total) }}đ</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="text-end">
                <p class="mb-1">Tạm tính: {{ number_format($order->subtotal) }}đ</p>
                <p class="mb-1">Giảm giá: -{{ number_format($order->discount) }}đ</p>
                <p class="mb-1">Phí vận chuyển: {{ number_format($order->shipping_fee) }}đ</p>
                <h5 class="fw-bold">Tổng cộng: <span class="text-danger">{{ number_format($order->total) }}đ</span></h5>
            </div>
        </div>
    </div>
 
    <div class="col-md-4">
        <div class="card stat-card p-4 mb-3">
            <h6 class="fw-bold mb-3">Thông tin khách hàng</h6>
            <p class="mb-1"><strong>Họ tên:</strong> {{ $order->customer_name }}</p>
            <p class="mb-1"><strong>SĐT:</strong> {{ $order->customer_phone }}</p>
            <p class="mb-1"><strong>Email:</strong> {{ $order->customer_email ?? '-' }}</p>
            <p class="mb-1"><strong>Địa chỉ:</strong> {{ $order->shipping_address }}</p>
            <p class="mb-0"><strong>Ghi chú:</strong> {{ $order->note ?? '-' }}</p>
        </div>
 
        <div class="card stat-card p-4">
            <h6 class="fw-bold mb-3">Cập nhật trạng thái</h6>
 
            @php
                // Thứ tự luồng chính, dùng để xác định option nào bị khoá lại (đã đi qua)
                $statusFlow = ['pending', 'confirmed', 'shipping', 'completed'];
                $currentIndex = array_search($order->status, $statusFlow);
                $isLocked = in_array($order->status, ['completed', 'cancelled']);
            @endphp
 
            @if($isLocked)
                {{-- Đơn đã ở trạng thái cuối: chỉ hiển thị, không cho sửa --}}
                <div class="alert alert-secondary mb-0">
                    Đơn hàng đã ở trạng thái
                    <strong>{{ $order->status === 'completed' ? 'Hoàn tất' : 'Huỷ đơn' }}</strong>
                    và không thể thay đổi.
                </div>
            @else
                <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                    @csrf @method('PATCH')
                    <select name="status" class="form-select mb-3">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}
                            {{ $currentIndex > array_search('pending', $statusFlow) ? 'disabled' : '' }}>
                            Chờ xác nhận
                        </option>
                        <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}
                            {{ $currentIndex > array_search('confirmed', $statusFlow) ? 'disabled' : '' }}>
                            Đã xác nhận
                        </option>
                        <option value="shipping" {{ $order->status == 'shipping' ? 'selected' : '' }}
                            {{ $currentIndex > array_search('shipping', $statusFlow) ? 'disabled' : '' }}>
                            Đang giao hàng
                        </option>
                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>
                            Hoàn tất
                        </option>
                        <option value="cancelled">Huỷ đơn</option>
                    </select>
                    <button class="btn btn-warning text-white fw-semibold w-100">Cập nhật</button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
 
