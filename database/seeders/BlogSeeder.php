<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Cách chọn gạo nếp ngon để đồ xôi dẻo thơm',
                'excerpt' => 'Bí quyết chọn gạo nếp cái hoa vàng giúp món xôi dẻo, thơm và không bị khô cứng khi nguội.',
                'content' => 'Gạo nếp là yếu tố quyết định độ dẻo thơm của món xôi. Nên chọn loại nếp cái hoa vàng, hạt tròn đều, không bị gãy vụn. Trước khi đồ, gạo cần được ngâm nước từ 6-8 tiếng để hạt nếp nở đều, giúp xôi chín mềm mà vẫn giữ được độ dẻo tự nhiên.',
            ],
            [
                'title' => 'Ý nghĩa của xôi gấc trong văn hoá lễ Tết Việt Nam',
                'excerpt' => 'Vì sao xôi gấc luôn xuất hiện trong mâm cỗ ngày Tết và các dịp cưới hỏi quan trọng?',
                'content' => 'Màu đỏ của xôi gấc tượng trưng cho sự may mắn, thịnh vượng trong văn hoá người Việt. Vào các dịp lễ Tết, cưới hỏi, xôi gấc thường được chuẩn bị như một lời chúc phúc, cầu mong một năm mới an lành và hạnh phúc.',
            ],
            [
                'title' => 'Xôi mặn thập cẩm - bữa sáng đầy đủ dinh dưỡng',
                'excerpt' => 'Kết hợp giữa gạo nếp, thịt, chả và trứng, xôi mặn thập cẩm là lựa chọn hoàn hảo cho bữa sáng bận rộn.',
                'content' => 'Một phần xôi mặn thập cẩm thường có đầy đủ tinh bột từ gạo nếp, đạm từ thịt kho, chả lụa, trứng cút, cùng vị béo của hành phi và mỡ hành, mang lại năng lượng dồi dào cho buổi sáng làm việc hiệu quả.',
            ],
        ];

        foreach ($posts as $p) {
            BlogPost::create([
                'title' => $p['title'],
                'slug' => Str::slug($p['title']) . '-' . Str::random(4),
                'excerpt' => $p['excerpt'],
                'content' => $p['content'],
                'meta_title' => $p['title'],
                'meta_description' => $p['excerpt'],
                'is_published' => true,
                'published_at' => now()->subDays(rand(1, 20)),
            ]);
        }
    }
}
