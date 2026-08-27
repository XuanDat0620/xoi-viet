@extends('layouts.app')

@section('title', 'Đơn hàng của tôi - Xôi Việt')

@section('content')
<div class="container mt-4 mb-5">
    <h1 class="fw-bold h3 mb-4">Đơn hàng của tôi</h1>

    <div class="card border-0 shadow-sm" style="border-radius: 16px;">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr><th>Mã đơn</th><th>Ngày đặt</th><th>Tổng tiền</th><th>Trạng thái</th><th></th></tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td class="fw-semibold">{{ $order->order_code }}</td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ number_format($order->total) }}đ</td>
                            <td><span class="badge bg-warning text-white">{{ $order->status_label }}</span></td>
                            <td>
                                <form action="{{ route('orders.track') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="order_code" value="{{ $order->order_code }}">
                                    <input type="hidden" name="customer_phone" value="{{ $order->customer_phone }}">
                                    <button class="btn btn-sm btn-outline-warning">Xem chi tiết</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">Bạn chưa có đơn hàng nào.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3">{{ $orders->links() }}</div>
</div>
@endsection
