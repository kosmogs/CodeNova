<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PqrController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\GestorController;
use App\Http\Controllers\Admin\UsersController;



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
    Route::middleware(['role:2'])->group(function () {
        Route::get('/supervisor/dashboard', fn() => view('supervisor.dashboard'))
            ->name('supervisor.dashboard');
    });

    // ---------------- GESTOR ----------------
    Route::middleware(['role:3'])->group(function () {
    //Index
    Route::get('/gestor/pqrs', [GestorController::class, 'index'])
    ->name('gestor.pqrs.index');
    //Estado
    Route::post('/gestor/pqrs/{id}/estado', [GestorController::class, 'cambiarEstado'])
    ->name('gestor.pqrs.estado');
    //Historial
    Route::get('/gestor/pqrs/{id}/historial', [PqrController::class, 'verHistorial'])
    ->name('gestor.pqrs.historial');

        //Route::get('/gestor/pqrs', [GestorController::class, 'index'])
          //  ->name('gestor.pqrs')
            //->middleware('auth', 'role:3'); ole gay y lo de los portatiles que

        // Cambiar estado
        Route::post('/gestor/pqrs/{id}/estado', [GestorController::class, 'cambiarEstado'])
            ->name('gestor.pqrs.estado');
            });

    // ---------------- CLIENTE ----------------
    Route::middleware(['role:4'])->group(function () {
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
