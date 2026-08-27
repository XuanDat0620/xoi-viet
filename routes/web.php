<?php

use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;



Route::get('/', [HomeController::class, 'index'])->name('home');

// Tìm kiếm & danh mục sản phẩm
Route::get('/san-pham', [ProductController::class, 'index'])->name('products.index');
Route::get('/tim-kiem', [ProductController::class, 'search'])->name('products.search');
Route::get('/san-pham/{slug}', [ProductController::class, 'show'])->name('products.show');

// Giỏ hàng
Route::prefix('gio-hang')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/them/{product}', [CartController::class, 'add'])->name('add');
    Route::post('/mua-ngay/{product}', [CartController::class, 'buyNow'])->name('buyNow');
    Route::patch('/cap-nhat/{productId}', [CartController::class, 'update'])->name('update');
    Route::delete('/xoa/{productId}', [CartController::class, 'remove'])->name('remove');
    Route::post('/ma-giam-gia', [CartController::class, 'applyCoupon'])->name('coupon');
});

// Thanh toán
Route::prefix('thanh-toan')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/', [CheckoutController::class, 'store'])->name('store');
    Route::get('/thanh-cong/{orderCode}', [CheckoutController::class, 'success'])->name('success');
});

// Theo dõi đơn hàng
Route::get('/tra-cuu-don-hang', [OrderController::class, 'trackForm'])->name('orders.trackForm');
Route::post('/tra-cuu-don-hang', [OrderController::class, 'track'])->name('orders.track');

// Tin tức / Blog
Route::get('/tin-tuc', [BlogController::class, 'index'])->name('blog.index');
Route::get('/tin-tuc/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Liên hệ / Giới thiệu
Route::get('/lien-he', [ContactController::class, 'index'])->name('contact.index');
Route::post('/lien-he', [ContactController::class, 'store'])->name('contact.store');


Route::middleware('guest')->group(function () {
    Route::get('/dang-nhap', [LoginController::class, 'showForm'])->name('login');
    Route::post('/dang-nhap', [LoginController::class, 'login'])->name('login.submit');
    Route::get('/dang-ky', [RegisterController::class, 'showForm'])->name('register');
    Route::post('/dang-ky', [RegisterController::class, 'register'])->name('register.submit');
});

Route::middleware('auth')->group(function () {
    Route::post('/dang-xuat', [LoginController::class, 'logout'])->name('logout');
    Route::get('/tai-khoan/don-hang', [OrderController::class, 'myOrders'])->name('orders.myOrders');
});


Route::prefix('admin')->name('admin.')->group(function () {

    // ===== Đăng nhập Admin: giao diện RIÊNG BIỆT, khác hoàn toàn trang khách hàng =====
    Route::middleware('guest')->group(function () {
        Route::get('/dang-nhap', [AdminLoginController::class, 'showForm'])->name('login');
        Route::post('/dang-nhap', [AdminLoginController::class, 'login'])->name('login.submit');
    });

    // ===== Các trang quản trị: bắt buộc đăng nhập + đúng quyền admin =====
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('san-pham', AdminProductController::class)
            ->parameters(['san-pham' => 'product'])
            ->names('products');

        Route::get('don-hang', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('don-hang/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::patch('don-hang/{order}/trang-thai', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');

        Route::get('khach-hang', [CustomerController::class, 'index'])->name('customers.index');
        Route::get('khach-hang/{customer}', [CustomerController::class, 'show'])->name('customers.show');
    });
});
