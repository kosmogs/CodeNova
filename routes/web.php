<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Rutas para dashboards
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');
    Route::get('/supervisor/dashboard', fn() => view('supervisor.dashboard'))->name('supervisor.dashboard');
    Route::get('/gestor/dashboard', fn() => view('gestor.dashboard'))->name('gestor.dashboard');
    Route::get('/cliente/dashboard', fn() => view('cliente.dashboard'))->name('cliente.dashboard');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
