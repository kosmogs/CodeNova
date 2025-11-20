<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PqrController;
use App\Http\Controllers\ClienteController;


Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth'])->group(function () {

    // ---------------- ADMIN ----------------
    Route::middleware(['role:Administrador'])->group(function () {
        Route::get('/admin/dashboard', fn() => view('admin.dashboard'))
            ->name('admin.dashboard');

        // Vistas propias del admin
        Route::get('/admin/pqrs/crear', fn() => view('admin.crear'))->name('admin.pqrs.crear');
        Route::get('/admin/pqrs/{id}/detalles', fn($id) => view('admin.detalles', compact('id')))
            ->name('admin.pqrs.detalles');
        Route::get('/admin/pqrs/{id}/editar', fn($id) => view('admin.editar', compact('id')))
            ->name('admin.pqrs.editar');
    });

    // ---------------- SUPERVISOR ----------------
    Route::middleware(['role:Supervisor'])->group(function () {
        Route::get('/supervisor/dashboard', fn() => view('supervisor.dashboard'))
            ->name('supervisor.dashboard');
    });

    // ---------------- GESTOR ----------------
    Route::middleware(['role:Gestor'])->group(function () {
        Route::get('/gestor/dashboard', fn() => view('gestor.dashboard'))
            ->name('gestor.dashboard');

        // Si el gestor edita PQR
        Route::get('/gestor/{id}/edit', fn($id) => view('gestor.edit', compact('id')))
            ->name('gestor.edit');
    });

    // ---------------- CLIENTE ----------------
    Route::middleware(['role:Cliente'])->group(function () {
        Route::get('/cliente/dashboard', [ClienteController::class, 'index'])
            ->name('cliente.dashboard');

        Route::get('/pqr/{id}/historial', [PqrController::class, 'verHistorial'])
            ->name('pqr.historial')
            ->middleware('auth');    

        Route::get('/pqr/create', fn() => view('pqr.create'))
            ->name('pqr.create');
            
        Route::post('/pqr/store', [PqrController::class, 'store'])->name('pqr.store');
    });
});
//Ruta para store
Route::resource('pqr', PqrController::class);


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
