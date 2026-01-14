<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return redirect('/login');
});

//auth
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

//admin
Route::prefix('admin')->group(function () {

    Route::get('/', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

    //pesanan masuk
    Route::get('/orders/incoming', [AdminController::class, 'orders_incoming'])
        ->name('admin.orders.incoming');

    //pesanan selesai
    Route::get('/orders', [AdminController::class, 'orders'])
        ->name('admin.orders');

    //update status
    Route::patch('/orders/{batch}/status', [AdminController::class, 'updateOrderStatus'])
        ->name('admin.orders.updateStatus');

    //menu
    Route::get('/menu', [MenuController::class, 'index'])
        ->name('admin.menu.index');

    Route::post('/menu', [MenuController::class, 'store'])
        ->name('admin.menu.store');

    Route::put('/menu/{id}', [MenuController::class, 'update'])
        ->name('admin.menu.update');

    Route::delete('/menu/{id}', [MenuController::class, 'destroy'])
        ->name('admin.menu.destroy');

    Route::patch('/menu/{id}/status', [MenuController::class, 'updateStatus'])
        ->name('admin.menu.status');
});

//user
Route::get('/user', [UserController::class, 'dashboard'])
    ->name('user.dashboard');

Route::get('/user/pesan', [UserController::class, 'index'])
    ->name('user.pesan');

Route::post('/user/order', [UserController::class, 'order'])
    ->name('user.order');

Route::get('/user/success', [UserController::class, 'success'])
    ->name('user.success');

Route::get('/user/orders/history', [UserController::class, 'history'])
    ->name('user.orders.history');

Route::get('/user/orders/status/{batch}', [UserController::class, 'orderStatus'])
    ->name('user.orders.status');
