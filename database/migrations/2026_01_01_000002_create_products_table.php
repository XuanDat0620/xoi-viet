<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('name');                 // Ví dụ: Xôi xéo đặc biệt
            $table->string('slug')->unique();
            $table->string('thumbnail')->nullable(); // Ảnh đại diện
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->unsignedInteger('price');         // Giá bán hiện tại (VNĐ)
            $table->unsignedInteger('original_price')->nullable(); // Giá gốc (để hiển thị giảm giá)
            $table->unsignedInteger('stock')->default(100); // Số phần còn trong ngày
            $table->string('unit')->default('phần');  // Đơn vị tính: phần, hộp, suất
            $table->decimal('rating', 2, 1)->default(5.0);
            $table->unsignedInteger('sold_count')->default(0);
            $table->boolean('is_featured')->default(false); // Sản phẩm nổi bật ở Trang chủ
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['name']); // hỗ trợ tìm kiếm
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
