@extends('layouts.admin')

@section('title', 'Thêm sản phẩm')
@section('page-title', 'Thêm sản phẩm mới')

@section('content')
<div class="card stat-card p-4" style="max-width: 700px;">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.products._form', ['product' => null])
        <button type="submit" class="btn btn-warning text-white fw-semibold px-4">Lưu sản phẩm</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Huỷ</a>
    </form>
</div>
@endsection
