<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    protected int $shippingFee = 15000; // Phí ship đồng giá nội thành, có thể tuỳ biến

    // Hiển thị form điền thông tin người mua + phương thức thanh toán
    public function index()
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['qty']);
        $coupon = session('coupon');
        $discount = $coupon ? $coupon['discount'] : 0;
        $total = $subtotal - $discount + $this->shippingFee;

        return view('checkout.index', compact('cart', 'subtotal', 'discount', 'total'));
    }

    // Xử lý đặt hàng: Họ tên, SĐT, địa chỉ nhận hàng + phương thức thanh toán
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:100',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email',
            'shipping_address' => 'required|string|max:255',
            'payment_method' => 'required|in:cod,bank_transfer,momo,vnpay',
            'note' => 'nullable|string|max:500',
        ]);

        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['qty']);
        $coupon = session('coupon');
        $discount = $coupon ? $coupon['discount'] : 0;
        $total = $subtotal - $discount + $this->shippingFee;

        foreach ($cart as $productId => $item) {
        $product = Product::find($productId);

        if (! $product || $product->stock < $item['qty']) {
            return back()->with('error', 'Sản phẩm "' . $item['name'] . '" không đủ số lượng tồn kho (còn lại: ' . ($product->stock ?? 0) . ').');
        }
    }

     $order = DB::transaction(function () use ($request, $cart, $subtotal, $discount, $total, $coupon) {
        $order = Order::create([
            'order_code' => 'XV' . now()->format('ymd') . strtoupper(Str::random(4)),
            'user_id' => auth()->id(),
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_email' => $request->customer_email,
            'shipping_address' => $request->shipping_address,
            'note' => $request->note,
            'payment_method' => $request->payment_method,
            'payment_status' => 'pending',
            'status' => 'pending',
            'subtotal' => $subtotal,
            'discount' => $discount,
            'shipping_fee' => $this->shippingFee,
            'total' => $total,
            'coupon_code' => $coupon['code'] ?? null,
        ]);

        foreach ($cart as $productId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'product_name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['qty'],
                'line_total' => $item['price'] * $item['qty'],
            ]);
        
        // ===== Trừ tồn kho + cộng số lượng đã bán =====
            $product = Product::lockForUpdate()->find($productId);
            $product->decrement('stock', $item['qty']);
            $product->increment('sold_count', $item['qty']);
        }

        return $order;
    });

        // Dọn giỏ hàng sau khi đặt thành công
        session()->forget(['cart', 'coupon']);

        return redirect()->route('checkout.success', $order->order_code);
    }

    // Trang cảm ơn sau khi đặt hàng thành công, kèm mã đơn để tra cứu
    public function success(string $orderCode)
    {
        $order = Order::with('items')->where('order_code', $orderCode)->firstOrFail();
        return view('checkout.success', compact('order'));
    }
}
