<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\ProdukController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\PelangganController;
use App\Http\Controllers\Api\PembelianController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\ProfilController;
use Illuminate\Http\Request;

Route::apiResource('users', UserApiController::class);
Route::apiResource('books', BookController::class);

Route::apiResource('produks', ProdukController::class);
Route::post('/produks/{id}/images', [ProdukController::class, 'uploadImages']);
Route::post('/produks/{id}/images/update', [ProdukController::class, 'updateImages']);

Route::apiResource('orders', OrderController::class);
Route::put('orders/{id}/status', [OrderController::class, 'updateStatus']);


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/pelanggan', [PelangganController::class, 'index']);
    Route::post('/pelanggan', [PelangganController::class, 'store']);
    Route::get('/pelanggan/phone/{no_hp}', [PelangganController::class, 'findByPhone']);
    Route::put('/pelanggan/{id}', [PelangganController::class, 'update']);
    Route::delete('/pelanggan/{id}', [PelangganController::class, 'destroy']);

    // Supplier Routes
    Route::get('/suppliers', [SupplierController::class, 'index']);
    Route::post('/suppliers', [SupplierController::class, 'store']);
    Route::get('/suppliers/{supplier}', [SupplierController::class, 'show']);
    Route::put('/suppliers/{supplier}', [SupplierController::class, 'update']);
    Route::delete('/suppliers/{supplier}', [SupplierController::class, 'destroy']);

    // Pembelian Routes
    Route::get('/pembelians', [PembelianController::class, 'index']);
    Route::post('/pembelians', [PembelianController::class, 'store']);
    Route::get('/pembelians/{pembelian}', [PembelianController::class, 'show']);
    Route::patch('/pembelians/{pembelian}/status', [PembelianController::class, 'updateStatus']);
    Route::delete('/pembelians/{pembelian}', [PembelianController::class, 'destroy']);

    // Profil
    Route::get('/profil', [ProfilController::class, 'show']);
    Route::put('/profil', [ProfilController::class, 'update']);
    Route::put('/profil/password', [ProfilController::class, 'updatePassword']);
    Route::post('/profil/foto', [ProfilController::class, 'uploadFoto']);
});
