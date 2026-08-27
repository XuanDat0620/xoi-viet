<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Form để khách nhập Mã đơn hàng + SĐT tra cứu
    public function trackForm()
    {
        return view('orders.track');
    }

    // Tìm và hiển thị trạng thái đơn hàng
    public function track(Request $request)
    {
        $request->validate([
            'order_code' => 'required|string',
            'customer_phone' => 'required|string',
        ]);

        $order = Order::with('items')
            ->where('order_code', $request->order_code)
            ->where('customer_phone', $request->customer_phone)
            ->first();

        if (!$order) {
            return back()->with('error', 'Không tìm thấy đơn hàng. Vui lòng kiểm tra lại Mã đơn và Số điện thoại.');
        }

        return view('orders.track', compact('order'));
    }

    // Danh sách đơn hàng của khách đã đăng nhập ("Tài khoản của tôi")
    public function myOrders()
    {
        $orders = auth()->user()->orders()->latest()->paginate(10);
        return view('orders.my-orders', compact('orders'));
    }
}
