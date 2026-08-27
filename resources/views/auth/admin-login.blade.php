<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập quản trị - Xôi Việt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Be Vietnam Pro', sans-serif;
            background: radial-gradient(circle at top left, #3D241A, #1a0f0a 70%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }
        .admin-login-card {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            backdrop-filter: blur(6px);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
        }
        .admin-badge {
            display: inline-block;
            background: linear-gradient(135deg, #A3242A, #7A1B20);
            border-radius: 50%;
            width: 60px; height: 60px;
            line-height: 60px;
            font-size: 28px;
        }
        .form-control {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.15);
            color: #fff;
        }
        .form-control:focus {
            background: rgba(255,255,255,0.1);
            color: #fff;
            box-shadow: 0 0 0 3px rgba(163,36,42,0.35);
            border-color: #A3242A;
        }
        .form-control::placeholder { color: rgba(255,255,255,0.4); }
        .btn-admin {
            background: linear-gradient(135deg, #A3242A, #7A1B20);
            color: #fff;
            font-weight: 600;
            border: none;
        }
        .btn-admin:hover { color: #fff; opacity: 0.9; }
        a.back-site { color: rgba(255,255,255,0.5); font-size: 14px; }
        a.back-site:hover { color: #d9807f; }
    </style>
</head>
<body>
    <div class="admin-login-card text-center">
        <span class="admin-badge">🔐</span>
        <h1 class="h4 fw-bold mt-3 mb-1">Khu vực Quản trị</h1>
        <p class="text-white-50 mb-4">Xôi Việt Admin Panel</p>

        @error('email')
            <div class="alert alert-danger py-2 text-start small">{{ $message }}</div>
        @enderror

        <form action="{{ route('admin.login.submit') }}" method="POST" class="text-start">
            @csrf
            <div class="mb-3">
                <label class="form-label small text-white-50">Email quản trị</label>
                <input type="email" name="email" class="form-control" placeholder="admin@xoiviet.vn" required autofocus>
            </div>
            <div class="mb-4">
                <label class="form-label small text-white-50">Mật khẩu</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-admin w-100 py-2">Đăng nhập quản trị</button>
        </form>

        <div class="alert alert-light border-0 mt-4 small text-dark mb-0">
            <strong>Demo:</strong> admin@xoiviet.vn / 123456
        </div>

        <a href="{{ route('home') }}" class="back-site d-block mt-4">
            <i class="bi bi-arrow-left"></i> Quay về trang bán hàng
        </a>
    </div>
</body>
</html>
