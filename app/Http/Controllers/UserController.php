<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        if (!Auth::check() || Auth::user()->role !== 'user') {
            abort(403, 'Hanya user yang dapat mengakses halaman ini');
        }

        $menus = Menu::where('is_available', 1)->get();
        return view('user.dashboard', compact('menus'));
    }

    public function order(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'user') {
            abort(403, 'Admin tidak diperbolehkan melakukan pemesanan');
        }

        $request->validate([
            'menu_id'   => 'required|array',
            'quantity'  => 'required|array',
        ]);

        $menuIds    = $request->menu_id;
        $quantities = $request->quantity;

        $batchCode = 'TRX-' . now()->format('YmdHis') . '-' . Str::random(6);

        foreach ($menuIds as $i => $menuId) {
            $qty = (int) ($quantities[$i] ?? 0);

            if ($qty > 0) {
                $menu = Menu::findOrFail($menuId);

                Order::create([
                    'user_id'     => Auth::id(),
                    'menu_id'     => $menu->id,
                    'quantity'    => $qty,
                    'total_price' => $menu->price * $qty,
                    'order_date'  => now(),
                    'order_batch' => $batchCode,
                ]);
            }
        }

        return redirect()->route('user.success');
    }

    public function success()
    {
        if (!Auth::check() || Auth::user()->role !== 'user') {
            abort(403);
        }

        return view('user.success');
    }

    public function history()
    {
        if (!Auth::check() || Auth::user()->role !== 'user') {
            abort(403, 'Admin tidak dapat melihat riwayat pesanan user');
        }

        $orders = Order::with('menu')
            ->where('user_id', Auth::id())
            ->orderBy('order_date', 'desc')
            ->get()
            ->groupBy('order_batch');

        return view('user.history', compact('orders'));
    }
}
