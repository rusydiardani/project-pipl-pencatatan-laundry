<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MedController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Models\Transaction;

/*
|--------------------------------------------------------------------------
| Route: Halaman Login dan Autentikasi
|--------------------------------------------------------------------------
*/

// Halaman login (hanya untuk guest), jika auth redirect ke dashboard (Home baru)
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : view('pages.login');
})->name('login');

// Test Toast Route
Route::get('/test-toast', function () {
    return redirect()->route('dashboard')->with('success', 'Ini adalah pesan tes Toast! 🚀');
});

// Proses login
Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process')
    ->middleware('guest');



/*
|--------------------------------------------------------------------------
| Route: Setelah Login (auth required)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /*
    --------------------------------------------------------------------------
    | Pencarian Produk (Obat dan Service)
    |--------------------------------------------------------------------------
    */   

    Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');

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
    | CRUD Transaksi (Shared: Admin & Staff)
    |--------------------------------------------------------------------------
    */
    Route::resource('transaction', TransactionController::class)->except(['destroy']);
    Route::post('/transactions/store', [TransactionController::class, 'store'])->name('transactions.store');
    
    // List Page
    Route::get('/list', [TransactionController::class, 'listPage'])->name('list.page');
    
    // Print Receipt
    Route::get('/transactions/print/{ref_no}', [TransactionController::class, 'printReceipt'])->name('transactions.print');
    
    // Edit & Update Transaction
    Route::get('/transactions/{ref_no}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
    Route::put('/transactions/{ref_no}', [TransactionController::class, 'updateByRef'])->name('transactions.updateByRef');
    
    // Detail
    Route::get('/detail/{ref_no}', [\App\Http\Controllers\TransactionController::class, 'detailByRef'])->name('transactions.detail');


    /*
    |--------------------------------------------------------------------------
    | ADMIN ONLY ROUTES
    |--------------------------------------------------------------------------
    */
    Route::middleware('isAdmin')->group(function () {
        // Master Data
        Route::resource('service', ServiceController::class);
        Route::resource('products', ProductController::class);
        Route::resource('customers', CustomerController::class);
        
        // User Management
        Route::resource('staff', StaffController::class);
        Route::resource('user', UserController::class);

        // Delete Transaction (Admin Only)
        Route::delete('/transactions/ref/{ref_no}', [TransactionController::class, 'destroyByRef'])->name('transactions.destroyByRef');
        
        // Reports (Admin Only)
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/generate', [ReportController::class, 'generate'])->name('reports.generate');
    });
    /*
    |--------------------------------------------------------------------------
    | Halaman Buat Transaksi (SPA-like / Form)
    |--------------------------------------------------------------------------
    */
    Route::get('/buat', [TransactionController::class, 'createPage'])->name('buat.page');
});

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
