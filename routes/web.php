<?php

use App\Http\Controllers\ChartOfAccountController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\WarehouseController;
use App\Livewire\Home;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('home', ['title' => 'Home Page']));

Route::get('/report', [JournalController::class, 'index']);

Route::get('/setting', fn () => view('setting.index', ['title' => 'Setting Page']));

Route::group(['middleware' => 'guest'], function () {
    Route::get('/setting/warehouse', [WarehouseController::class, 'index']);
    Route::get('/setting/account', [ChartOfAccountController::class, 'index'])->name('account.index');
    Route::get('/setting/account/{id}/edit', [ChartOfAccountController::class, 'edit']);
    Route::put('/setting/account/{id}/edit', [ChartOfAccountController::class, 'update'])->name('account.update');
});
