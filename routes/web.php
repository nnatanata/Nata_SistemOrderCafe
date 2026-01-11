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
Route::get('/login', [AuthController::class, 'loginForm']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'registerForm']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/logout', [AuthController::class, 'logout']);

//admin
Route::prefix('admin')->group(function () {

    Route::get('/', [AdminController::class, 'orders'])
        ->name('admin.dashboard');

    Route::get('/menu', [MenuController::class,'index'])
        ->name('admin.menu.index');

    Route::post('/menu', [MenuController::class,'store'])
        ->name('admin.menu.store');

    Route::put('/menu/{id}', [MenuController::class,'update'])
        ->name('admin.menu.update');

    Route::delete('/menu/{id}', [MenuController::class,'destroy'])
        ->name('admin.menu.destroy');

    Route::patch('/menu/{id}/status', [MenuController::class,'updateStatus'])
        ->name('admin.menu.status');

    Route::get('/orders', [AdminController::class, 'orders'])
        ->name('admin.orders');
});

//user
Route::get('/user', [UserController::class, 'index'])
    ->name('user.dashboard');

Route::post('/user/order', [UserController::class, 'order'])
    ->name('user.order');

Route::get('/user/success', [UserController::class, 'success'])
    ->name('user.success');

Route::get('/user/orders/history', [UserController::class, 'history'])
    ->name('user.orders.history');
