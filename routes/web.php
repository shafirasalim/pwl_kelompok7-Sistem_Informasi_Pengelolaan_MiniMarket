<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SaleDetailController;

Route::resource('sale-details', SaleDetailController::class);

Route::resource('sales', SaleController::class);

Route::resource('stock-movements', StockMovementController::class);

Route::resource('products', ProductController::class);

Route::resource('branches', BranchController::class);

Route::resource('stocks', StockController::class);

Route::resource('users', UserController::class);