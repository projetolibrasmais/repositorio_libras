<?php

use App\Http\Controllers\LogController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\SinalController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('permissions', PermissionController::class)->only(['index', 'show']);

    Route::resource('roles', RoleController::class);

    Route::resource('categorias', CategoriaController::class);

    Route::resource('sinais', SinalController::class)->parameters([
    'sinais' => 'sinal']);
    
    Route::resource('logs', LogController::class)->only(['index', 'show']);

    Route::post('/users/restore/{id}', [UserController::class, 'restore'])->name('users.restore');
    Route::delete('/users/force-delete/{id}', [UserController::class, 'forceDelete'])->name('users.force-delete');
    Route::resource('users', UserController::class);
});

require __DIR__.'/auth.php';
