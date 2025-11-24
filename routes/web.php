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
    Route::middleware(['role:1'])
        ->prefix('admin')
        ->as('admin.')
        ->group(function () {

            // Dashboard admin
            Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
                ->name('dashboard');
            //Ruta editar usuario
            Route::get('/admin/users/{usuario}/edit', [UsersController::class, 'edit'])
                ->name('admin.users.edit');
            Route::put('/admin/users/{usuario}', [UsersController::class, 'update'])
                ->name('admin.users.update');

            // CRUD supervisores y gestores
            Route::resource('users', App\Http\Controllers\Admin\UsersController::class)->parameters(['users'=>'user']);
            //Ruta eliminar usuario
            Route::delete('/admin/users/{id}', [UsersController::class, 'destroy'])
                ->name('admin.users.destroy');

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
