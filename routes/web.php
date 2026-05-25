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
    Route::get('/expedientes/crear', [\App\Http\Controllers\ExpedienteController::class, 'create'])->name('expedientes.create');
    Route::post('/expedientes', [\App\Http\Controllers\ExpedienteController::class, 'store'])->name('expedientes.store');
    Route::get('/api/expedientes/search', [\App\Http\Controllers\ExpedienteController::class, 'search'])->name('expedientes.search');
    Route::get('/expedientes/{mascota}/consultas', [\App\Http\Controllers\ConsultaController::class, 'consultas'])->name('expedientes.consultas');
    Route::get('/expedientes/{mascota}/consultas/crear', [\App\Http\Controllers\ConsultaController::class, 'createConsulta'])->name('expedientes.consultas.create');
    Route::post('/expedientes/{mascota}/consultas', [\App\Http\Controllers\ConsultaController::class, 'storeConsulta'])->name('expedientes.consultas.store');
    Route::get('/expedientes/{mascota}/consultas/{consulta}', [\App\Http\Controllers\ConsultaController::class, 'showConsulta'])->name('expedientes.consultas.show');
    Route::get('/expedientes/{mascota}/consultas/{consulta}/diagnostico', [\App\Http\Controllers\ConsultaController::class, 'diagnostico'])->name('expedientes.consultas.diagnostico');
    Route::post('/expedientes/{mascota}/consultas/{consulta}/diagnostico', [\App\Http\Controllers\ConsultaController::class, 'updateDiagnostico'])->name('expedientes.consultas.diagnostico.update');
    
    // Tratamiento (belonging to consulta)
    Route::get('/expedientes/{mascota}/consultas/{consulta}/tratamiento', [\App\Http\Controllers\ConsultaController::class, 'tratamiento'])->name('expedientes.consultas.tratamiento');
    Route::post('/expedientes/{mascota}/consultas/{consulta}/tratamiento', [\App\Http\Controllers\ConsultaController::class, 'updateTratamiento'])->name('expedientes.consultas.tratamiento.update');

    // Mascota related history
    Route::get('/expedientes/{mascota}/alergias', [\App\Http\Controllers\HistorialMedicoController::class, 'alergias'])->name('expedientes.mascotas.alergias');
    Route::post('/expedientes/{mascota}/alergias', [\App\Http\Controllers\HistorialMedicoController::class, 'updateAlergias'])->name('expedientes.mascotas.alergias.update');
    
    Route::get('/expedientes/{mascota}/lesiones', [\App\Http\Controllers\HistorialMedicoController::class, 'lesiones'])->name('expedientes.mascotas.lesiones');
    Route::post('/expedientes/{mascota}/lesiones', [\App\Http\Controllers\HistorialMedicoController::class, 'updateLesiones'])->name('expedientes.mascotas.lesiones.update');
    
    Route::get('/expedientes/{mascota}/patologicos', [\App\Http\Controllers\HistorialMedicoController::class, 'patologicos'])->name('expedientes.mascotas.patologicos');
    Route::post('/expedientes/{mascota}/patologicos', [\App\Http\Controllers\HistorialMedicoController::class, 'updatePatologicos'])->name('expedientes.mascotas.patologicos.update');
    
    Route::get('/expedientes/{mascota}/nutricion', [\App\Http\Controllers\HistorialMedicoController::class, 'nutricion'])->name('expedientes.mascotas.nutricion');
    Route::post('/expedientes/{mascota}/nutricion', [\App\Http\Controllers\HistorialMedicoController::class, 'updateNutricion'])->name('expedientes.mascotas.nutricion.update');

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

