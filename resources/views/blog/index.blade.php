@extends('layouts.app')

@section('title', 'Tin tức & Mẹo vặt - Xôi Việt')
@section('meta_description', 'Chia sẻ kiến thức, hướng dẫn về cách chọn nguyên liệu và văn hoá ẩm thực xôi Việt Nam.')

@section('content')
<div class="container mt-4 mb-5">
    <h1 class="fw-bold h3 mb-4">Tin tức & Mẹo vặt nhà bếp</h1>

    <div class="row g-4">
        @foreach($posts as $post)
            <div class="col-md-4">
                <a href="{{ route('blog.show', $post->slug) }}" class="text-decoration-none text-dark">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                        <img src="{{ $post->thumbnail ? asset('storage/'.$post->thumbnail) : 'https://placehold.co/400x220/A3242A/fff?text=Xoi+Viet+Blog' }}" class="card-img-top" style="height: 180px; object-fit: cover; border-radius: 16px 16px 0 0;">
                        <div class="card-body">
                            <small class="text-muted">{{ $post->published_at?->format('d/m/Y') }}</small>
                            <h5 class="fw-bold mt-1">{{ $post->title }}</h5>
                            <p class="text-muted">{{ Str::limit($post->excerpt, 90) }}</p>
                            <span class="text-warning fw-semibold">Đọc thêm →</span>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <div class="mt-4">{{ $posts->links() }}</div>
</div>
@endsection
