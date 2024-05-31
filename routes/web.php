<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ChartOfAccountController;

Route::get('/', [AuthController::class, 'index'])->name('auth.index');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');



Route::group(['middleware' => 'auth'], function () {

    Route::get('/setting', fn () => view('setting.index', ['title' => 'Setting Page']));

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
    Route::get('/journal/{id}/edit', [JournalController::class, 'edit']);
    Route::put('/journal/{id}/edit', [JournalController::class, 'update'])->name('journal.update');
    Route::get('/report', [JournalController::class, 'dailyreport'])->name('dailyreport.index');
    Route::get('/administrator', [JournalController::class, 'administrator'])->name('journal.administrator');
});
