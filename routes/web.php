<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\GoodsController;
use App\Http\Controllers\OrderController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Dashboard', [
    ]);
})->name('dashboard');

Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');
//Goods
Route::get('/goods', [GoodsController::class, 'index'])->name('goods.index');
//Order
Route::get('/order', [OrderController::class, 'index'])->name('order.index');
Route::get('/order/create', [OrderController::class, 'AddOrder'])->name('order.create');
Route::get('/order/create/detail', [OrderController::class, 'AddOrderDetail'])->name('order.create.detail');
Route::get('/order/edit/detail', [OrderController::class, 'EditOrderDetail'])->name('order.edit.detail');
Route::get('/order/edit/detail/update', [OrderController::class, 'UpdateOrderDetail'])->name('order.update.detail');

//Process
Route::get('/order/process', [OrderController::class,'ProcessDate'])->name('order.process');

//report
Route::get('/order/report', [OrderController::class,'OrderReport'])->name('order.report');

require __DIR__.'/auth.php';
