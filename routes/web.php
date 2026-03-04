<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('admin', [AdminController::class, 'index']);
Route::post('admin', [AdminController::class, 'store']);
Route::post('ajax-data-admin', [AdminController::class, 'ajaxDataAdmin']);
