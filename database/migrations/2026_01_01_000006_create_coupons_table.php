<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();  // Ví dụ: XOINGON10
            $table->enum('type', ['percent', 'fixed'])->default('percent');
            $table->unsignedInteger('value'); // 10 (%) hoặc 20000 (VNĐ)
            $table->unsignedInteger('min_order_total')->default(0);
            $table->date('expires_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
