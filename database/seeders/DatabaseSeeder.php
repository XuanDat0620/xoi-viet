<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Tài khoản Admin mặc định
        User::create([
            'name' => 'Quản trị viên',
            'email' => 'admin@xoiviet.vn',
            'password' => Hash::make('123456'),
            'phone' => '0900000000',
            'role' => 'admin',
        ]);

        // Tài khoản khách hàng mẫu
        User::create([
            'name' => 'Nguyễn Văn A',
            'email' => 'khachhang@gmail.com',
            'password' => Hash::make('123456'),
            'phone' => '0912345678',
            'role' => 'customer',
        ]);

        // Danh mục sản phẩm theo mô tả đề bài
        $categories = [
            ['name' => 'Xôi xéo', 'slug' => 'xoi-xeo', 'description' => 'Gạo nếp vàng ươm nghệ, đậu xanh, hành phi giòn.'],
            ['name' => 'Xôi gấc', 'slug' => 'xoi-gac', 'description' => 'Màu đỏ tự nhiên, vị ngọt bùi, tượng trưng may mắn.'],
            ['name' => 'Xôi lạc / Xôi ngô', 'slug' => 'xoi-lac-xoi-ngo', 'description' => 'Món quà sáng bình dị, ăn kèm muối vừng.'],
            ['name' => 'Xôi mặn thập cẩm', 'slug' => 'xoi-man-thap-cam', 'description' => 'Ăn kèm thịt kho, lạp xưởng, gà xé, chả, trứng cút.'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        $products = [
            ['cat' => 'xoi-xeo', 'name' => 'Xôi xéo đậu xanh hành phi', 'price' => 20000, 'original_price' => 25000, 'featured' => true],
            ['cat' => 'xoi-xeo', 'name' => 'Xôi xéo đặc biệt thêm chả', 'price' => 28000, 'original_price' => null, 'featured' => false],
            ['cat' => 'xoi-gac', 'name' => 'Xôi gấc truyền thống', 'price' => 22000, 'original_price' => null, 'featured' => true],
            ['cat' => 'xoi-gac', 'name' => 'Xôi gấc dừa nạo', 'price' => 25000, 'original_price' => 30000, 'featured' => false],
            ['cat' => 'xoi-lac-xoi-ngo', 'name' => 'Xôi lạc muối vừng', 'price' => 15000, 'original_price' => null, 'featured' => true],
            ['cat' => 'xoi-lac-xoi-ngo', 'name' => 'Xôi ngô nước cốt dừa', 'price' => 18000, 'original_price' => null, 'featured' => false],
            ['cat' => 'xoi-man-thap-cam', 'name' => 'Xôi mặn thập cẩm đầy đủ', 'price' => 35000, 'original_price' => 40000, 'featured' => true],
            ['cat' => 'xoi-man-thap-cam', 'name' => 'Xôi gà xé lạp xưởng', 'price' => 32000, 'original_price' => null, 'featured' => true],
        ];

        foreach ($products as $p) {
            $category = Category::where('slug', $p['cat'])->first();
            Product::create([
                'category_id' => $category->id,
                'name' => $p['name'],
                'slug' => Str::slug($p['name']) . '-' . Str::random(4),
                'short_description' => 'Món xôi truyền thống, thơm ngon, được gói cẩn thận, giao nóng hổi tận nơi.',
                'description' => 'Được nấu từ gạo nếp cái hoa vàng chọn lọc, đồ chín bằng hơi nước theo cách truyền thống, giữ trọn hương vị đặc trưng của ẩm thực Việt Nam.',
                'price' => $p['price'],
                'original_price' => $p['original_price'],
                'stock' => 100,
                'unit' => 'phần',
                'rating' => 4.8,
                'sold_count' => rand(20, 300),
                'is_featured' => $p['featured'],
                'is_active' => true,
            ]);
        }

        // Mã giảm giá mẫu
        Coupon::create([
            'code' => 'XOINGON10',
            'type' => 'percent',
            'value' => 10,
            'min_order_total' => 50000,
            'expires_at' => now()->addMonths(3),
            'is_active' => true,
        ]);

        Coupon::create([
            'code' => 'GIAM20K',
            'type' => 'fixed',
            'value' => 20000,
            'min_order_total' => 100000,
            'expires_at' => now()->addMonths(3),
            'is_active' => true,
        ]);

        $this->call([BlogSeeder::class]);
    }
}
