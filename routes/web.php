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

    Route::view('/expedientes', 'modules.expedientes.index')->name('expedientes.index');
    Route::get('/api/expedientes/search', [\App\Http\Controllers\ExpedienteController::class, 'search'])->name('expedientes.search');
    Route::get('/expedientes/{mascota}/consultas', [\App\Http\Controllers\ExpedienteController::class, 'consultas'])->name('expedientes.consultas');
    Route::get('/expedientes/{mascota}/consultas/{consulta}', [\App\Http\Controllers\ExpedienteController::class, 'showConsulta'])->name('expedientes.consultas.show');
    Route::get('/expedientes/{mascota}/consultas/{consulta}/diagnostico', [\App\Http\Controllers\ExpedienteController::class, 'diagnostico'])->name('expedientes.consultas.diagnostico');
    Route::post('/expedientes/{mascota}/consultas/{consulta}/diagnostico', [\App\Http\Controllers\ExpedienteController::class, 'updateDiagnostico'])->name('expedientes.consultas.diagnostico.update');

    // Dashboard Veterinario
    Route::middleware('role:veterinario')->group(function () {
        Route::get('/home', [AuthController::class, 'home'])->name('home');
    });

    // Dashboard Administrador
    Route::middleware('role:administrador')->prefix('admin')->group(function () {
        Route::get('/home', [AuthController::class, 'adminHome'])->name('admin.home');
        Route::get('/usuarios', [UserController::class, 'index'])->name('admin.users.index');
        Route::get('/usuarios/crear', [UserController::class, 'create'])->name('admin.users.create');
        Route::post('/usuarios', [UserController::class, 'store'])->name('admin.users.store');
        Route::get('/usuarios/{user}', [UserController::class, 'show'])->name('admin.users.show');
        Route::get('/usuarios/{user}/editar', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/usuarios/{user}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/usuarios/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    });

});

