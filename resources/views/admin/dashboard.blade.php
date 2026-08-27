@extends('layouts.admin')

@section('title', 'Tổng quan')
@section('page-title', 'Tổng quan hệ thống')

@section('content')

{{-- ===== THẺ SỐ LIỆU TỔNG QUAN ===== --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card stat-card p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted">Tổng doanh thu</small>
                    <h4 class="fw-bold text-warning mb-0">{{ number_format($totalRevenue) }}đ</h4>
                </div>
                <i class="bi bi-cash-stack fs-1 text-warning"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted">Tổng đơn hàng</small>
                    <h4 class="fw-bold mb-0">{{ $totalOrders }}</h4>
                </div>
                <i class="bi bi-receipt fs-1 text-primary"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted">Sản phẩm</small>
                    <h4 class="fw-bold mb-0">{{ $totalProducts }}</h4>
                </div>
                <i class="bi bi-box-seam fs-1 text-success"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted">Khách hàng</small>
                    <h4 class="fw-bold mb-0">{{ $totalCustomers }}</h4>
                </div>
                <i class="bi bi-people fs-1 text-info"></i>
            </div>
        </div>
    </div>
</div>

@if($pendingOrders > 0)
    <div class="alert alert-warning">
        <i class="bi bi-exclamation-circle-fill"></i>
        Bạn có <strong>{{ $pendingOrders }}</strong> đơn hàng đang chờ xác nhận.
        <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="alert-link">Xem ngay</a>
    </div>
@endif

<div class="row g-4">
    {{-- ===== BIỂU ĐỒ DOANH THU 7 NGÀY ===== --}}
    <div class="col-md-8">
        <div class="card stat-card p-4">
            <h6 class="fw-bold mb-3">Doanh thu 7 ngày gần nhất</h6>
            <canvas id="revenueChart" height="100"></canvas>
        </div>
    </div>

    {{-- ===== TOP SẢN PHẨM BÁN CHẠY ===== --}}
    <div class="col-md-4">
        <div class="card stat-card p-4">
            <h6 class="fw-bold mb-3">Top sản phẩm bán chạy</h6>
            @foreach($topProducts as $p)
                <div class="d-flex justify-content-between mb-2">
                    <span>{{ Str::limit($p->name, 25) }}</span>
                    <span class="fw-semibold text-warning">{{ $p->sold_count }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>

{{-- ===== ĐƠN HÀNG MỚI NHẤT ===== --}}
<div class="card stat-card p-4 mt-4">
    <h6 class="fw-bold mb-3">Đơn hàng mới nhất</h6>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead class="table-light">
                <tr><th>Mã đơn</th><th>Khách hàng</th><th>Tổng tiền</th><th>Trạng thái</th><th>Ngày đặt</th></tr>
            </thead>
            <tbody>
                @foreach($recentOrders as $order)
                    <tr>
                        <td><a href="{{ route('admin.orders.show', $order) }}">{{ $order->order_code }}</a></td>
                        <td>{{ $order->customer_name }}</td>
                        <td>{{ number_format($order->total) }}đ</td>
                        <td><span class="badge bg-warning text-white">{{ $order->status_label }}</span></td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Doanh thu (VNĐ)',
                data: @json($chartData),
                borderColor: '#A3242A',
                backgroundColor: 'rgba(163,36,42,0.12)',
                tension: 0.35,
                fill: true,
            }]
        },
        options: { plugins: { legend: { display: false } } }
    });
</script>
@endpush
@endsection
