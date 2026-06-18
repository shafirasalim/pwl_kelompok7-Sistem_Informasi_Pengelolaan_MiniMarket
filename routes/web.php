<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

// Redirect halaman utama ke dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Dashboard (Wajib login)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Group routes yang WAJIB LOGIN
Route::middleware('auth')->group(function () {
    
    // Profile routes (Bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Resource Routes (CRUD Otomatis)
    Route::resource('branches', BranchController::class);
    Route::resource('products', ProductController::class);
    Route::resource('stocks', StockController::class);
    Route::resource('stock-movements', StockMovementController::class);
    Route::resource('users', UserController::class);
    Route::resource('sales', SaleController::class);

    // Report Routes (Custom)
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/sales', [ReportController::class, 'salesReport'])->name('reports.sales');
    Route::get('/reports/stock', [ReportController::class, 'stockReport'])->name('reports.stock');
});

require __DIR__.'/auth.php';