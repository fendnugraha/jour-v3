<?php

use App\Livewire\Home;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ChartOfAccountController;

Route::get('/', fn () => view('home', ['title' => 'Home Page']));

Route::get('/report', [JournalController::class, 'index']);

Route::get('/setting', fn () => view('setting.index', ['title' => 'Setting Page']));

Route::group(['middleware' => 'guest'], function () {
    Route::get('/setting/user', [AuthController::class, 'users'])->name('user.index');
    Route::get('/setting/user/{id}/edit', [AuthController::class, 'edit']);
    Route::put('/setting/user/{id}/edit', [AuthController::class, 'update'])->name('user.update');

    Route::get('/setting/warehouse', [WarehouseController::class, 'index'])->name('warehouse.index');
    Route::get('/setting/warehouse/{id}/edit', [WarehouseController::class, 'edit']);
    Route::put('/setting/warehouse/{id}/edit', [WarehouseController::class, 'update'])->name('warehouse.update');


    Route::get('/setting/account', [ChartOfAccountController::class, 'index'])->name('account.index');
    Route::get('/setting/account/{id}/edit', [ChartOfAccountController::class, 'edit']);
    Route::put('/setting/account/{id}/edit', [ChartOfAccountController::class, 'update'])->name('account.update');
});
