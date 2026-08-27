<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Khi người dùng CHƯA đăng nhập cố truy cập trang cần đăng nhập,
     * Laravel sẽ gọi hàm này để biết chuyển hướng về đâu.
     *
     * Nếu đường dẫn bắt đầu bằng /admin -> đưa về trang đăng nhập Admin (giao diện riêng).
     * Ngược lại -> đưa về trang đăng nhập khách hàng bình thường.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        return $request->is('admin*') ? route('admin.login') : route('login');
    }
}
