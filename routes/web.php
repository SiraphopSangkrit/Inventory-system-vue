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
Route::post('/customer', [CustomerController::class,'StoreCus'])->name('customer.store');
Route::patch('/customer/{id}', [CustomerController::class,'UpdateCus'])->name('customer.update');
//Goods
Route::get('/goods', [GoodsController::class, 'index'])->name('goods.index');
Route::post('/goods', [GoodsController::class, 'StoreGoods'])->name('goods.store');
Route::patch('/goods/{id}', [GoodsController::class,'UpdateGoods'])->name('goods.update');
Route::delete('/goods/{id}', [GoodsController::class, 'GoodsDestroy'])->name('goods.destroy');
//Order
Route::get('/order', [OrderController::class, 'index'])->name('order.index');
Route::delete('/order', [OrderController::class, 'OrderHeaderDelete'])->name('order.delete.header');
Route::get('/order/create', [OrderController::class, 'AddOrder'])->name('order.create.header');
Route::post('/order/create', [OrderController::class, 'OrderHeaderStore'])->name('order.header.store');
Route::get('/order/create/detail/customer:{cus_id}/order:{order_id}', [OrderController::class, 'AddOrderDetail'])->name('order.create.detail');
Route::post('/order/create/detail/', [OrderController::class, 'OrderDetailStore'])->name('order.create.detail.store');
Route::get('/order/create/goods/search', [OrderController::class, 'GoodsSearch'])->name('order.goods.search');
Route::get('/order/detail/customer:{cus_id}/order:{order_id}', [OrderController::class, 'OrderDetail'])->name('order.detail');
Route::get('/order/detail/customer:{cus_id}/order:{order_id}/edit/detail:{order_detail_id}', [OrderController::class, 'EditOrderDetail'])->name('order.edit.detail');
Route::patch('/order/detail/customer:{cus_id}/order:{order_id}/edit/detail:{order_detail_id}', [OrderController::class, 'UpdateOrderDetail'])->name('order.edit.detail.update');
Route::delete('/order/detail/customer:{cus_id}/order:{order_id}', [OrderController::class, 'DeleteOrderDetails'])->name('order.delete.detail');
Route::get('/order/create/search', [GoodsController::class, 'CusSearch'])->name('order.create.search');
//Process
Route::get('/order/process', [OrderController::class,'ProcessDatePage'])->name('order.process.page');
Route::post('/order/process', [OrderController::class,'ProcessDate'])->name('order.process');
//report
Route::get('/order/report', [OrderController::class,'OrderReport'])->name('order.report');

require __DIR__.'/auth.php';
