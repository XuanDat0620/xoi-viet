<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Trang danh mục sản phẩm: bộ lọc theo giá + sắp xếp
    public function index(Request $request)
    {
        $filters = [
            'keyword'   => $request->get('q'),
            'category'  => $request->get('category'),
            'price_min' => $request->get('price_min'),
            'price_max' => $request->get('price_max'),
            'sort'      => $request->get('sort'),
        ];

        $products = Product::active()
            ->with('category')
            ->filter($filters)
            ->paginate(12)
            ->withQueryString();

        $categories = Category::where('is_active', true)->get();

        return view('products.index', compact('products', 'categories', 'filters'));
    }

    // Trang chi tiết sản phẩm
    public function show(string $slug)
    {
        $product = Product::active()
            ->with(['category', 'images'])
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedProducts = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    // Ô tìm kiếm sản phẩm ở header (chuyển hướng sang trang danh mục có lọc theo từ khoá)
    public function search(Request $request)
    {
        $request->validate(['q' => 'nullable|string|max:100']);
        return redirect()->route('products.index', ['q' => $request->get('q')]);
    }
}
