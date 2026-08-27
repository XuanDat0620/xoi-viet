@extends('layouts.app')

@section('title', 'Đăng nhập - Xôi Việt')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-sm p-4" style="border-radius: 16px;">
                <h1 class="fw-bold h4 text-center mb-1">🍚 Đăng nhập</h1>
                <p class="text-center text-muted mb-4">Chào mừng bạn quay lại với Xôi Việt</p>

                @error('email')
                    <div class="alert alert-danger py-2">{{ $message }}</div>
                @enderror

                <form action="{{ route('login.submit') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mật khẩu</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
                    </div>
                    <button type="submit" class="btn btn-warning fw-semibold text-white w-100 py-2">Đăng nhập</button>
                </form>

                <p class="text-center mt-3 mb-0">
                    Chưa có tài khoản? <a href="{{ route('register') }}" class="text-warning fw-semibold">Đăng ký ngay</a>
                </p>

                <div class="alert alert-light border mt-3 small mb-0">
                    <strong>Tài khoản demo:</strong><br>
                    Admin: admin@xoiviet.vn / 123456<br>
                    Khách hàng: khachhang@gmail.com / 123456
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
