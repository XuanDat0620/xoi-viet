<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
     protected array $statusFlow = ['pending', 'confirmed', 'shipping', 'completed'];
 
    public function index(Request $request)
    {
        $orders = Order::with('items')
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->q, fn($q) => $q->where(function ($q) use ($request) {
                $q->where('order_code', 'like', "%{$request->q}%")
                  ->orWhere('customer_name', 'like', "%{$request->q}%")
                  ->orWhere('customer_phone', 'like', "%{$request->q}%");
            }))
            ->latest()
            ->paginate(15)
            ->withQueryString();
 
        return view('admin.orders.index', compact('orders'));
    }
 
    public function show(Order $order)
    {
        $order->load('items');
        return view('admin.orders.show', compact('order'));
    }
 
    // Cập nhật trạng thái đơn: pending -> confirmed -> shipping -> completed / cancelled
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,shipping,completed,cancelled',
        ]);
 
        $newStatus = $request->status;
        $currentStatus = $order->status;
 
        // ===== Đơn đã ở trạng thái cuối (completed / cancelled) thì khoá, không cho đổi nữa =====
        if (in_array($currentStatus, ['completed', 'cancelled'])) {
            return back()->with('error', 'Đơn hàng đã ở trạng thái cuối cùng, không thể thay đổi.');
        }
 
        // ===== Không cho phép chọn lùi về trạng thái trước đó trong luồng chính =====
        if ($newStatus !== 'cancelled') {
            $currentIndex = array_search($currentStatus, $this->statusFlow);
            $newIndex = array_search($newStatus, $this->statusFlow);
 
            if ($newIndex === false || $newIndex < $currentIndex) {
                return back()->with('error', 'Không thể chuyển về trạng thái trước đó.');
            }
        }
 
        $order->update(['status' => $newStatus]);
 
        // Nếu đơn hoàn tất, cộng dồn số lượng đã bán cho từng sản phẩm (phục vụ thống kê)
        if ($newStatus === 'completed') {
            foreach ($order->items as $item) {
                $item->product?->increment('sold_count', $item->quantity);
            }
        }
 
        return back()->with('success', 'Đã cập nhật trạng thái đơn hàng #' . $order->order_code);
    }
}
