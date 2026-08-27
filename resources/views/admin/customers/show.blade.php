@extends('layouts.admin')

@section('title', 'Chi tiết khách hàng')
@section('page-title', 'Chi tiết khách hàng')

@section('content')
<div class="card stat-card p-4 mb-4">
    <h6 class="fw-bold mb-3">Thông tin khách hàng</h6>
    <p class="mb-1"><strong>Họ tên:</strong> {{ $customer->name }}</p>
    <p class="mb-1"><strong>Email:</strong> {{ $customer->email }}</p>
    <p class="mb-1"><strong>SĐT:</strong> {{ $customer->phone ?? '-' }}</p>
    <p class="mb-1"><strong>Địa chỉ:</strong> {{ $customer->address ?? '-' }}</p>
    <p class="mb-0"><strong>Ngày tham gia:</strong> {{ $customer->created_at->format('d/m/Y') }}</p>
</div>

<div class="card stat-card p-4">
    <h6 class="fw-bold mb-3">Lịch sử đơn hàng</h6>
    <table class="table align-middle">
        <thead class="table-light">
            <tr><th>Mã đơn</th><th>Tổng tiền</th><th>Trạng thái</th><th>Ngày đặt</th><th></th></tr>
        </thead>
        <tbody>
            @forelse($customer->orders as $order)
                <tr>
                    <td>{{ $order->order_code }}</td>
                    <td>{{ number_format($order->total) }}đ</td>
                    <td><span class="badge bg-warning text-white">{{ $order->status_label }}</span></td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">Xem</a></td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted py-4">Khách hàng chưa có đơn hàng nào.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
