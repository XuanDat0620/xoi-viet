@extends('layouts.admin')

@section('title', 'Quản lý đơn hàng')
@section('page-title', 'Quản lý đơn hàng')

@section('content')
<div class="card stat-card p-4">
    <form method="GET" class="d-flex gap-2 mb-3">
        <input type="text" name="q" class="form-control" placeholder="Tìm theo mã đơn, tên, SĐT..." value="{{ request('q') }}">
        <select name="status" class="form-select" style="max-width: 220px;" onchange="this.form.submit()">
            <option value="">Tất cả trạng thái</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
            <option value="shipping" {{ request('status') == 'shipping' ? 'selected' : '' }}>Đang giao</option>
            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Hoàn tất</option>
            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã huỷ</option>
        </select>
        <button class="btn btn-outline-secondary"><i class="bi bi-search"></i></button>
    </form>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead class="table-light">
                <tr><th>Mã đơn</th><th>Khách hàng</th><th>SĐT</th><th>Tổng tiền</th><th>Thanh toán</th><th>Trạng thái</th><th>Ngày đặt</th><th></th></tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td class="fw-semibold">{{ $order->order_code }}</td>
                        <td>{{ $order->customer_name }}</td>
                        <td>{{ $order->customer_phone }}</td>
                        <td>{{ number_format($order->total) }}đ</td>
                        <td>
                            @php
                                $paymentLabels = ['cod' => 'COD', 'bank_transfer' => 'Chuyển khoản', 'momo' => 'MoMo', 'vnpay' => 'VNPay'];
                            @endphp
                            {{ $paymentLabels[$order->payment_method] ?? $order->payment_method }}
                        </td>
                        <td><span class="badge bg-warning text-white">{{ $order->status_label }}</span></td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">Chi tiết</a></td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center text-muted py-4">Không có đơn hàng nào.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $orders->links() }}</div>
</div>
@endsection
