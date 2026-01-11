<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::orderBy('id','desc')->get();
        return view('admin.menu', compact('menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric|min:0',
            'is_available' => 'required|boolean'
        ]);

        Menu::create([
            'name' => $request->name,
            'price' => $request->price,
            'is_available' => $request->is_available
        ]);

        return back()->with('success','Menu berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric|min:0',
            'is_available' => 'required|boolean'
        ]);

        Menu::findOrFail($id)->update([
            'name' => $request->name,
            'price' => $request->price,
            'is_available' => $request->is_available
        ]);

        return back()->with('success','Menu berhasil diupdate');
    }

    public function destroy($id)
    {
        Menu::findOrFail($id)->delete();
        return back()->with('success','Menu berhasil dihapus');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'is_available' => 'required|boolean'
        ]);

        Menu::findOrFail($id)->update([
            'is_available' => $request->is_available
        ]);

        return back();
    }
}
