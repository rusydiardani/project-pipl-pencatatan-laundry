<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LaundryItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Route: Halaman Login dan Autentikasi
|--------------------------------------------------------------------------
*/

// Halaman login (hanya untuk guest)
Route::get('/', [AuthController::class, 'showLogin'])->middleware('guest');

// Proses login
Route::post('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');

/*
|--------------------------------------------------------------------------
| Route: Setelah Login (auth required)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    /*
    |--------------------------------------------------------------------------
    | Ganti Password
    |--------------------------------------------------------------------------
    */
    Route::post('/password/update', [UserController::class, 'updatePassword'])->name('password.update');

    /*
    |--------------------------------------------------------------------------
    | Dashboard Utama
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | CRUD Pelanggan (Customers)
    |--------------------------------------------------------------------------
    */
    Route::resource('customers', CustomerController::class);

    /*
    |--------------------------------------------------------------------------
    | CRUD Jenis Layanan Laundry (Laundry Items)
    |--------------------------------------------------------------------------
    */
    Route::resource('laundry-items', LaundryItemController::class);

    /*
    |--------------------------------------------------------------------------
    | CRUD Pesanan (Orders)
    |--------------------------------------------------------------------------
    */
    Route::resource('orders', OrderController::class);
    Route::get('/orders/{order}/print', [OrderController::class, 'print'])->name('orders.print');
    Route::post('/orders/{order}/payment', [OrderController::class, 'addPayment'])->name('orders.payment');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');

    /*
    |--------------------------------------------------------------------------
    | CRUD Staff dan User (hanya admin)
    |--------------------------------------------------------------------------
    */
    Route::middleware('isAdmin')->group(function () {
        Route::resource('staff', StaffController::class);
        Route::resource('users', UserController::class);
    });

    /*
    |--------------------------------------------------------------------------
    | Laporan
    |--------------------------------------------------------------------------
    */
    Route::get('/reports', function () {
        return view('pages.reports');
    })->name('reports');
});
