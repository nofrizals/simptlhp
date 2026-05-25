<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\InstansiController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\KasusController;
use App\Http\Controllers\NilaiKerugianController;
use App\Http\Controllers\ObrikController;
use App\Http\Controllers\ObrikTurunanController;
use App\Http\Controllers\StatusTlController;
use App\Http\Controllers\TimController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('admin', [AdminController::class, 'index']);
Route::post('admin', [AdminController::class, 'store']);
// Route::get('admin/{admin}/edit', [AdminController::class, 'edit']);
Route::delete('admin/{admin}', [AdminController::class, 'destroy']);
Route::post('ajax-data-admin', [AdminController::class, 'ajaxDataAdmin']);
Route::post('instansi/getMyTurunan', [InstansiController::class, 'getMyTurunan']);

// Master -> Jenis-php
Route::get('jenis-php', [JenisController::class, 'index']);
Route::post('jenis-php', [JenisController::class, 'store']);
Route::delete('jenis-php/{jenisPhp}', [JenisController::class, 'destroy']);
Route::post('ajax-data-jenis-php', [JenisController::class, 'ajaxDataJenisPHP']);

// Master -> nilai-kerugian
Route::get('nilai-kerugian', [NilaiKerugianController::class, 'index']);
Route::post('nilai-kerugian', [NilaiKerugianController::class, 'store']);
Route::delete('nilai-kerugian/{nilai_kerugian}', [NilaiKerugianController::class, 'destroy']);
Route::post('ajax-data-nilai-kerugian', [NilaiKerugianController::class, 'ajaxDataNilaiKerugian']);

// Master -> status-tl
Route::get('status-tl', [StatusTlController::class, 'index']);
Route::post('status-tl', [StatusTlController::class, 'store']);
Route::delete('status-tl/{status_tl}', [StatusTlController::class, 'destroy']);
Route::post('ajax-data-status-tl', [StatusTlController::class, 'ajaxDataStatusTl']);

// Master -> obrik
Route::get('obrik', [ObrikController::class, 'index']);
Route::post('obrik', [ObrikController::class, 'store']);
Route::delete('obrik/{obrik}', [ObrikController::class, 'destroy']);
Route::post('ajax-data-obrik', [ObrikController::class, 'ajaxDataObrik']);

// Master -> obrik-turunan
Route::get('obrik-turunan', [ObrikTurunanController::class, 'index']);
Route::post('obrik-turunan', [ObrikTurunanController::class, 'store']);
Route::delete('obrik-turunan/{obrik_turunan}', [ObrikTurunanController::class, 'destroy']);
Route::post('ajax-data-obrik-turunan', [ObrikTurunanController::class, 'ajaxDataObrikTurunan']);

// Manajemen Tim -> Tim
Route::get('daftar-tim', [TimController::class, 'index']);
Route::post('daftar-tim', [TimController::class, 'store']);
Route::delete('daftar-tim/{tim}', [TimController::class, 'destroy']);
Route::post('ajax-data-daftar-tim', [TimController::class, 'ajaxDataDaftarTim']);

// Manajemen Kasus -> Kasus
Route::get('daftar-kasus', [KasusController::class, 'index']);
Route::get('daftar-kasus/{id}/edit', [KasusController::class, 'edit']);
Route::post('daftar-kasus', [KasusController::class, 'store']);
Route::delete('daftar-kasus/{kasus}', [KasusController::class, 'destroy']);
Route::post('ajax-data-daftar-kasus', [KasusController::class, 'ajaxDataDaftarKasus']);
