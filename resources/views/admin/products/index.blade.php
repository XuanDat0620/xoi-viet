@extends('layouts.admin')

@section('title', 'Quản lý sản phẩm')
@section('page-title', 'Quản lý sản phẩm')

@section('content')
<div class="card stat-card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <form method="GET" class="d-flex gap-2">
            <input type="text" name="q" class="form-control" placeholder="Tìm theo tên sản phẩm..." value="{{ request('q') }}">
            <button class="btn btn-outline-secondary"><i class="bi bi-search"></i></button>
        </form>
        <a href="{{ route('admin.products.create') }}" class="btn btn-warning text-white fw-semibold">
            <i class="bi bi-plus-circle"></i> Thêm sản phẩm
        </a>
    </div>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead class="table-light">
                <tr>
                    <th>Ảnh</th><th>Tên sản phẩm</th><th>Danh mục</th><th>Giá bán</th>
                    <th>Tồn kho</th><th>Nổi bật</th><th>Trạng thái</th><th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td><img src="{{ $product->thumbnail ? asset('storage/'.$product->thumbnail) : 'https://placehold.co/50x50/A3242A/fff?text=X' }}" width="45" height="45" style="object-fit:cover;border-radius:8px;"></td>
                        <td class="fw-semibold">{{ $product->name }}</td>
                        <td>{{ $product->category->name ?? '-' }}</td>
                        <td>{{ number_format($product->price) }}đ</td>
                        <td>{{ $product->stock }}</td>
                        <td>
                            @if($product->is_featured)<span class="badge bg-warning text-white">Nổi bật</span>@endif
                        </td>
                        <td>
                            @if($product->is_active)
                                <span class="badge bg-success">Đang bán</span>
                            @else
                                <span class="badge bg-secondary">Đã ẩn</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Xoá sản phẩm này?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center text-muted py-4">Chưa có sản phẩm nào.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $products->links() }}</div>
</div>
@endsection
