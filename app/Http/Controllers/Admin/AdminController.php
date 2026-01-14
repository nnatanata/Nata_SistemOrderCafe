<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalOrders = Order::count();
        $incomingOrders = Order::whereIn('status', ['Baru', 'Diproses'])->count();
        $completedOrders = Order::where('status', 'Selesai')->count();
        $totalRevenue = Order::where('status', 'Selesai')->sum('total_price');
        $totalMenus = Menu::count();
        $todayOrders = Order::whereDate('order_date', now()->toDateString())->count();

        $topMenuData = Order::select('menu_id', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('menu_id')
            ->orderByDesc('total_sold')
            ->first();

        $topMenuName = 'N/A';
        if ($topMenuData) {
            $menu = Menu::find($topMenuData->menu_id);
            if ($menu) {
                $topMenuName = $menu->name . ' (' . $topMenuData->total_sold . ')';
            }
        }

        $days = collect(range(6, 0))->map(function ($i) {
            return now()->subDays($i)->format('Y-m-d');
        })->toArray();

        $orderStats = Order::select(DB::raw('DATE(order_date) as date'), DB::raw('COUNT(*) as orders'), DB::raw('SUM(total_price) as revenue'))
            ->whereDate('order_date', '>=', now()->subDays(6))
            ->groupBy(DB::raw('DATE(order_date)'))
            ->pluck('orders', 'date')
            ->toArray();

        $revenueStats = Order::select(DB::raw('DATE(order_date) as date'), DB::raw('SUM(total_price) as revenue'))
            ->whereDate('order_date', '>=', now()->subDays(6))
            ->groupBy(DB::raw('DATE(order_date)'))
            ->pluck('revenue', 'date')
            ->toArray();

        $chartLabels = array_map(function ($d) {
            return \Carbon\Carbon::parse($d)->format('d M');
        }, $days);

        $chartOrders = array_map(function ($d) use ($orderStats) {
            return isset($orderStats[$d]) ? (int) $orderStats[$d] : 0;
        }, $days);

        $chartRevenues = array_map(function ($d) use ($revenueStats) {
            return isset($revenueStats[$d]) ? (int) $revenueStats[$d] : 0;
        }, $days);

        $statusCounts = Order::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        return view('admin.dashboard', compact(
            'totalOrders',
            'incomingOrders',
            'completedOrders',
            'totalRevenue',
            'totalMenus',
            'todayOrders',
            'topMenuName',
            'chartLabels',
            'chartOrders',
            'chartRevenues',
            'statusCounts'
        ));
    }

    public function menu()
    {
        $menus = Menu::orderBy('id', 'desc')->get();
        return view('admin.menu', compact('menus'));
    }

    public function storeMenu(Request $request)
    {
        $request->validate([
            'name'         => 'required|string',
            'price'        => 'required|numeric|min:0',
            'is_available' => 'required|boolean'
        ]);

        Menu::create($request->only('name', 'price', 'is_available'));

        return back()->with('success', 'Menu berhasil ditambahkan');
    }

    public function updateMenu(Request $request, $id)
    {
        $request->validate([
            'name'         => 'required|string',
            'price'        => 'required|numeric|min:0',
            'is_available' => 'required|boolean'
        ]);

        Menu::where('id', $id)->update(
            $request->only('name', 'price', 'is_available')
        );

        return back()->with('success', 'Menu berhasil diperbarui');
    }

    public function deleteMenu($id)
    {
        Menu::where('id', $id)->delete();
        return back()->with('success', 'Menu berhasil dihapus');
    }

    public function toggleStatus(Request $request, $id)
    {
        Menu::where('id', $id)->update([
            'is_available' => $request->is_available
        ]);

        return back();
    }

    public function orders()
    {
        $groupedOrders = Order::with(['user', 'menu'])
            ->where('status', 'Selesai')
            ->orderBy('order_date', 'desc')
            ->get()
            ->groupBy('order_batch');

        return view('admin.orders', compact('groupedOrders'));
    }

    public function orders_incoming()
    {
        $groupedOrders = Order::with(['user', 'menu'])
            ->whereIn('status', ['Baru', 'Diproses'])
            ->orderBy('order_date', 'desc')
            ->get()
            ->groupBy('order_batch');

        return view('admin.orders_incoming', compact('groupedOrders'));
    }

    public function updateOrderStatus(Request $request, $batch)
    {
        $request->validate([
            'status' => 'required|in:Diproses,Selesai'
        ]);

        Order::where('order_batch', $batch)
            ->update([
                'status' => $request->status
            ]);

        return back()->with('success', 'Status pesanan berhasil diperbarui');
    }
}
