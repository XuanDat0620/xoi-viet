<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Chỉ cho phép user có role = admin truy cập khu vực quản trị.
     * Đăng ký middleware này với alias 'admin' trong app/Http/Kernel.php:
     *   'admin' => \App\Http\Middleware\AdminMiddleware::class,
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->is_admin) {
            abort(403, 'Bạn không có quyền truy cập.');
        }

        return $next($request);
    }
}
