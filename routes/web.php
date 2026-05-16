<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

// Rutas para usuarios NO autenticados (guest)
Route::middleware("guest")->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name('login');
    Route::post('/logear', [AuthController::class, 'logear'])->name('logear');
});

// Rutas para usuarios autenticados
Route::middleware("auth")->group(function () {

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard Veterinario
    Route::middleware('role:veterinario')->group(function () {
        Route::get('/home', [AuthController::class, 'home'])->name('home');
    });

    // Dashboard Administrador
    Route::middleware('role:administrador')->prefix('admin')->group(function () {
        Route::get('/home', [AuthController::class, 'adminHome'])->name('admin.home');
        Route::get('/usuarios', [UserController::class, 'index'])->name('admin.users.index');
    });

});

