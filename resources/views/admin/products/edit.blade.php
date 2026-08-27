@extends('layouts.admin')

@section('title', 'Sửa sản phẩm')
@section('page-title', 'Sửa sản phẩm')

@section('content')
<div class="card stat-card p-4" style="max-width: 700px;">
    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        @include('admin.products._form', ['product' => $product])
        <button type="submit" class="btn btn-warning text-white fw-semibold px-4">Cập nhật</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Huỷ</a>
    </form>
</div>
@endsection
