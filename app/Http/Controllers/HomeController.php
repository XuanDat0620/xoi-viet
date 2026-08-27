<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    // Trang chủ: banner, danh mục, sản phẩm nổi bật
    public function index()
    {
        $categories = Category::where('is_active', true)->get();

        $featuredProducts = Product::active()
            ->featured()
            ->with('category')
            ->latest()
            ->take(8)
            ->get();

        $bestSellers = Product::active()
            ->with('category')
            ->orderByDesc('sold_count')
            ->take(4)
            ->get();

        $latestPosts = BlogPost::published()->latest('published_at')->take(3)->get();

        return view('home', compact('categories', 'featuredProducts', 'bestSellers', 'latestPosts'));
    }
}
