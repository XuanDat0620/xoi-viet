<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique(); // Mã đơn để khách tra cứu, VD: XV20260820001
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            // Thông tin người nhận (Trang thanh toán)
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email')->nullable();
            $table->text('shipping_address');
            $table->text('note')->nullable();

            $table->string('payment_method'); // cod, bank_transfer, momo, vnpay
            $table->string('payment_status')->default('pending'); // pending, paid, failed
            $table->string('status')->default('pending');
            // pending -> confirmed -> shipping -> completed / cancelled

            $table->unsignedInteger('subtotal');       // Tạm tính
            $table->unsignedInteger('discount')->default(0); // Giảm giá từ mã coupon
            $table->unsignedInteger('shipping_fee')->default(0);
            $table->unsignedInteger('total');           // Tổng tiền cuối cùng
            $table->string('coupon_code')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
