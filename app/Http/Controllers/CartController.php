<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Giỏ hàng được lưu trong session dưới dạng mảng:
    // ['product_id' => ['name'=>.., 'price'=>.., 'qty'=>.., 'thumbnail'=>..], ...]

    public function index()
    {
        $cart = session('cart', []);
        $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['qty']);
        $coupon = session('coupon');
        $discount = $coupon ? $coupon['discount'] : 0;

        return view('cart.index', compact('cart', 'subtotal', 'discount', 'coupon'));
    }

    // Thêm vào giỏ hàng (dùng cho nút "Thêm vào giỏ hàng")
    public function add(Request $request, Product $product)
    {
        $qty = max(1, (int) $request->get('qty', 1));
        $cart = session('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['qty'] += $qty;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'qty' => $qty,
                'thumbnail' => $product->thumbnail,
                'slug' => $product->slug,
            ];
        }

        session(['cart' => $cart]);

        return back()->with('success', 'Đã thêm "' . $product->name . '" vào giỏ hàng.');
    }

    // "Mua ngay": thêm vào giỏ rồi chuyển thẳng tới trang thanh toán
    public function buyNow(Request $request, Product $product)
    {
        $this->add($request, $product);
        return redirect()->route('checkout.index');
    }

    public function update(Request $request, int $productId)
    {
        $qty = max(1, (int) $request->get('qty', 1));
        $cart = session('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['qty'] = $qty;
            session(['cart' => $cart]);
        }

        return back()->with('success', 'Đã cập nhật số lượng.');
    }

    public function remove(int $productId)
    {
        $cart = session('cart', []);
        unset($cart[$productId]);
        session(['cart' => $cart]);

        return back()->with('success', 'Đã xoá sản phẩm khỏi giỏ hàng.');
    }

    // Ô nhập mã giảm giá trong trang giỏ hàng
    public function applyCoupon(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        $cart = session('cart', []);
        $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['qty']);

        $coupon = Coupon::where('code', $request->code)->first();

        if (!$coupon || !$coupon->isValidFor($subtotal)) {
            return back()->with('error', 'Mã giảm giá không hợp lệ hoặc đơn hàng chưa đạt giá trị tối thiểu.');
        }

        $discount = $coupon->calculateDiscount($subtotal);

        session(['coupon' => [
            'code' => $coupon->code,
            'discount' => $discount,
        ]]);

        return back()->with('success', 'Áp dụng mã giảm giá thành công! Bạn được giảm ' . number_format($discount) . 'đ.');
    }
}
