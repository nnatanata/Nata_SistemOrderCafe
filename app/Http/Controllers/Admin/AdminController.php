<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return redirect()->route('admin.orders');
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
