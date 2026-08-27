<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Các số liệu tổng quan
        $totalRevenue = Order::where('status', 'completed')->sum('total');
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalCustomers = User::where('role', 'customer')->count();

        $pendingOrders = Order::where('status', 'pending')->count();

        // Doanh thu 7 ngày gần nhất, dùng để vẽ biểu đồ (Chart.js ở view)
        $revenueByDay = Order::where('status', 'completed')
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total) as revenue'))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $chartLabels = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $chartLabels[] = now()->subDays($i)->format('d/m');
            $chartData[] = (int) ($revenueByDay[$date]->revenue ?? 0);
        }

        // Top 5 sản phẩm bán chạy nhất
        $topProducts = Product::orderByDesc('sold_count')->take(5)->get();

        // Đơn hàng mới nhất
        $recentOrders = Order::latest()->take(8)->get();

        return view('admin.dashboard', compact(
            'totalRevenue', 'totalOrders', 'totalProducts', 'totalCustomers',
            'pendingOrders', 'chartLabels', 'chartData', 'topProducts', 'recentOrders'
        ));
    }
}
