<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        if (!Auth::check() || Auth::user()->role !== 'user') {
            return redirect('/login')->with('error', 'Akses ditolak: hanya user yang dapat mengakses halaman ini.');
        }

        $menus = Menu::where('is_available', 1)->get();
        return view('user.pesan', compact('menus'));
    }

    public function dashboard()
    {
        if (!Auth::check() || Auth::user()->role !== 'user') {
            return redirect('/login')->with('error', 'Akses ditolak: hanya user yang dapat mengakses halaman ini.');
        }

        $userId = Auth::id();

        $totalOrders = Order::where('user_id', $userId)->count();
        $totalSpent = Order::where('user_id', $userId)->where('status', 'Selesai')->sum('total_price');
        $todayOrders = Order::where('user_id', $userId)->whereDate('order_date', now()->toDateString())->count();
        $lastOrder = Order::where('user_id', $userId)->orderByDesc('order_date')->first();
        $lastOrderDate = $lastOrder ? $lastOrder->order_date->format('d M Y H:i') : 'N/A';

        $favorite = Order::select('menu_id', DB::raw('SUM(quantity) as total'))
            ->where('user_id', $userId)
            ->groupBy('menu_id')
            ->orderByDesc('total')
            ->first();

        $favoriteName = 'N/A';
        if ($favorite) {
            $menu = Menu::find($favorite->menu_id);
            if ($menu) $favoriteName = $menu->name . ' (' . $favorite->total . ')';
        }

        $recentOrders = Order::with('menu')
            ->where('user_id', $userId)
            ->orderByDesc('order_date')
            ->get()
            ->groupBy('order_batch')
            ->map(function ($batch, $code) {
                $first = $batch->first();
                return [
                    'batch' => $code,
                    'date' => $first->order_date->format('d M Y H:i'),
                    'status' => $first->status,
                    'total' => $batch->sum('total_price'),
                    'items' => $batch->map(function ($o) {
                        return [
                            'menu' => $o->menu->name,
                            'qty' => $o->quantity,
                            'subtotal' => $o->total_price,
                        ];
                    })->toArray(),
                ];
            })
            ->values()
            ->take(5)
            ->toArray();

        return view('user.dashboard', compact(
            'totalOrders', 'totalSpent', 'todayOrders', 'lastOrderDate', 'favoriteName', 'recentOrders'
        ));
    }

    public function order(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'user') {
            return redirect('/login')->with('error', 'Admin tidak diperbolehkan melakukan pemesanan.');
        }

        $request->validate([
            'menu_id'  => 'required|array',
            'quantity' => 'required|array',
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
                    'status'      => 'Baru',
                ]);
            }
        }

        return redirect()->route('user.success');
    }

    public function success()
    {
        if (!Auth::check() || Auth::user()->role !== 'user') {
            return redirect('/login')->with('error', 'Akses ditolak.');
        }

        return view('user.success');
    }

    public function history()
    {
        if (!Auth::check() || Auth::user()->role !== 'user') {
            return redirect('/login')->with('error', 'Akses ditolak: hanya user yang dapat melihat riwayat pesanan.');
        }

        $orders = Order::with('menu')
            ->where('user_id', Auth::id())
            ->orderBy('order_date', 'desc')
            ->get()
            ->groupBy('order_batch');

        return view('user.history', compact('orders'));
    }

    public function orderStatus($batch)
    {
        if (!Auth::check() || Auth::user()->role !== 'user') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $order = Order::where('order_batch', $batch)
            ->where('user_id', Auth::id())
            ->first();

        if (!$order) {
            return response()->json(['error' => 'Not found'], 404);
        }

        return response()->json([
            'batch' => $batch,
            'status' => $order->status,
        ]);
    }
}
