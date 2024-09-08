<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\PayableController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WarehouseController;
use App\Livewire\Journal\Payable\EditPayable;
use App\Http\Controllers\ChartOfAccountController;

Route::get('/', [AuthController::class, 'index'])->name('auth.index')->middleware('isLoggedIn');
Route::get('/login', [AuthController::class, 'index'])->name('auth.index')->middleware('isLoggedIn');
Route::post('/auth', [AuthController::class, 'authenticate'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');



Route::group(['middleware' => 'auth'], function () {

    Route::get('/setting', fn() => view('setting.index', ['title' => 'Setting Page']));

    Route::get('/setting/user', [AuthController::class, 'users'])->name('user.index');
    Route::get('/setting/user/{id}/edit', [AuthController::class, 'edit']);
    Route::put('/setting/user/{id}/edit', [AuthController::class, 'update'])->name('user.update');

    Route::get('/setting/warehouse', [WarehouseController::class, 'index'])->name('warehouse.index');
    Route::get('/setting/warehouse/{id}/edit', [WarehouseController::class, 'edit']);
    Route::put('/setting/warehouse/{id}/edit', [WarehouseController::class, 'update'])->name('warehouse.update');


    Route::get('/setting/account', [ChartOfAccountController::class, 'index'])->name('account.index');
    Route::get('/setting/account/{id}/edit', [ChartOfAccountController::class, 'edit']);
    Route::put('/setting/account/{id}/edit', [ChartOfAccountController::class, 'update'])->name('account.update');

    Route::get('/setting/product', [ProductController::class, 'index'])->name('product.index');
    Route::get('/setting/product/{id}/edit', [ProductController::class, 'edit']);
    Route::put('/setting/product/{id}/edit', [ProductController::class, 'update'])->name('product.update');

    Route::get('/setting/contact', [ContactController::class, 'index'])->name('contact.index');
    Route::get('/setting/contact/{id}/edit', [ContactController::class, 'edit']);
    Route::put('/setting/contact/{id}/edit', [ContactController::class, 'update'])->name('contact.update');

    Route::get('/journal', [JournalController::class, 'index'])->name('journal.index');
    Route::get('/home', [JournalController::class, 'index'])->name('journal.index');
    Route::get('/journal/{id}/edit', [JournalController::class, 'edit'])->name('journal.edit');
    Route::put('/journal/{id}/edit', [JournalController::class, 'update'])->name('journal.update');
    Route::get('/report', [JournalController::class, 'dailyreport'])->name('dailyreport.index');
    Route::get('/administrator', [JournalController::class, 'administrator'])->name('journal.administrator')->middleware('can:admin');

    Route::get('/finance', fn() => view('journal.finance', ['title' => 'Finance Page']))->name('finance.index');
    Route::get('/finance/payable/{id}/edit', [PayableController::class, 'edit'])->name('payable.edit');

    Route::get('/store', fn() => view('store.index', [
        'title' => 'Store Page',
    ]))->name('store.index');
    Route::get('/store/purchase', fn() => view('store.purchase', [
        'title' => 'PO Page',
    ]))->name('store.purchase');
    Route::get('/store/purchase/report', fn() => view('store.purchase.report', [
        'title' => 'PO Report',
    ]))->name('store.purchase.report');
    Route::get('/store/purchase/{id}/detail', fn($id) => view('store.purchase.detail', [
        'title' => 'PO Detail',
        'id' => $id
    ]))->name('store.purchase.detail');

    Route::get('/store/sales/report', fn() => view('store.sales.report', [
        'title' => 'SO Report',
    ]))->name('store.sales.report');
    Route::get('/store/sales/{id}/detail', fn($id) => view('store.sales.detail', [
        'title' => 'Sales Order Detail',
        'id' => $id
    ]))->name('store.sales.detail');

    Route::get('/clear-cart', function () {
        session()->forget('cart');
        return redirect()->back();
    })->name('clear.cart');
});
