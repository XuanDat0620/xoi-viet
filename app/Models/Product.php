<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'name', 'slug', 'thumbnail', 'short_description',
        'description', 'price', 'original_price', 'stock', 'unit',
        'rating', 'sold_count', 'is_featured', 'is_active',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    // Phần trăm giảm giá, dùng để hiển thị badge "-20%" ngoài giao diện
    public function getDiscountPercentAttribute(): int
    {
        if (!$this->original_price || $this->original_price <= $this->price) {
            return 0;
        }
        return (int) round((($this->original_price - $this->price) / $this->original_price) * 100);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Bộ lọc & tìm kiếm dùng chung cho Trang danh mục và Tìm kiếm
    public function scopeFilter($query, array $filters)
    {
        return $query
            ->when($filters['keyword'] ?? null, fn($q, $keyword) =>
                $q->where('name', 'like', "%{$keyword}%"))
            ->when($filters['category'] ?? null, fn($q, $cat) =>
                $q->whereHas('category', fn($c) => $c->where('slug', $cat)))
            ->when($filters['price_min'] ?? null, fn($q, $min) =>
                $q->where('price', '>=', $min))
            ->when($filters['price_max'] ?? null, fn($q, $max) =>
                $q->where('price', '<=', $max))
            ->when($filters['sort'] ?? null, function ($q, $sort) {
                return match ($sort) {
                    'price_asc' => $q->orderBy('price', 'asc'),
                    'price_desc' => $q->orderBy('price', 'desc'),
                    'newest' => $q->orderBy('created_at', 'desc'),
                    'bestseller' => $q->orderBy('sold_count', 'desc'),
                    default => $q->orderBy('created_at', 'desc'),
                };
            }, fn($q) => $q->orderBy('created_at', 'desc'));
    }
}
