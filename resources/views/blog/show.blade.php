@extends('layouts.app')

@section('title', ($post->meta_title ?: $post->title) . ' - Xôi Việt')
@section('meta_description', $post->meta_description ?: Str::limit($post->excerpt, 150))

@section('content')
<div class="container mt-4 mb-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('blog.index') }}">Tin tức</a></li>
            <li class="breadcrumb-item active">{{ $post->title }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-8">
            <h1 class="fw-bold h3">{{ $post->title }}</h1>
            <small class="text-muted">Đăng ngày {{ $post->published_at?->format('d/m/Y') }}</small>

            <img src="{{ $post->thumbnail ? asset('storage/'.$post->thumbnail) : 'https://placehold.co/700x350/A3242A/fff?text=Xoi+Viet+Blog' }}" class="img-fluid rounded-4 my-4">

            <div style="white-space: pre-line; line-height: 1.8;">{{ $post->content }}</div>
        </div>

        <div class="col-md-4">
            <h6 class="fw-bold mb-3">Bài viết liên quan</h6>
            @foreach($relatedPosts as $related)
                <a href="{{ route('blog.show', $related->slug) }}" class="d-block text-decoration-none text-dark mb-3">
                    <div class="card border-0 shadow-sm p-2 flex-row align-items-center" style="border-radius: 12px;">
                        <img src="{{ $related->thumbnail ? asset('storage/'.$related->thumbnail) : 'https://placehold.co/80x80/A3242A/fff?text=Xoi' }}" width="70" height="70" style="object-fit:cover; border-radius: 8px;">
                        <span class="ms-3 fw-semibold small">{{ Str::limit($related->title, 60) }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
@endsection
