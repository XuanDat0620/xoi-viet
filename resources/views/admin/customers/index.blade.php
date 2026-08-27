@extends('layouts.admin')

@section('title', 'Quản lý khách hàng')
@section('page-title', 'Quản lý khách hàng')

@section('content')
<div class="card stat-card p-4">
    <form method="GET" class="d-flex gap-2 mb-3">
        <input type="text" name="q" class="form-control" placeholder="Tìm theo tên, email, SĐT..." value="{{ request('q') }}">
        <button class="btn btn-outline-secondary"><i class="bi bi-search"></i></button>
    </form>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead class="table-light">
                <tr><th>Họ tên</th><th>Email</th><th>SĐT</th><th>Số đơn hàng</th><th>Ngày tham gia</th><th></th></tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                    <tr>
                        <td class="fw-semibold">{{ $customer->name }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->phone ?? '-' }}</td>
                        <td><span class="badge bg-info text-dark">{{ $customer->orders_count }}</span></td>
                        <td>{{ $customer->created_at->format('d/m/Y') }}</td>
                        <td><a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-sm btn-outline-primary">Chi tiết</a></td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Chưa có khách hàng nào.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $customers->links() }}</div>
</div>
@endsection
