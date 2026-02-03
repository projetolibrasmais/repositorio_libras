<?php

use App\Http\Controllers\LogController;
use App\Http\Controllers\MaterialController;
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

    Route::post('/categorias/restore/{id}', [CategoriaController::class, 'restore'])->name('categorias.restore');
    Route::delete('/categorias/force-delete/{id}', [CategoriaController::class, 'forceDelete'])->name('categorias.force-delete');
    Route::resource('categorias', CategoriaController::class);

    Route::post('/sinais/restore/{id}', [SinalController::class, 'restore'])->name('sinais.restore');
    Route::delete('/sinais/force-delete/{id}', [SinalController::class, 'forceDelete'])->name('sinais.force-delete');
    Route::delete('/sinais/{sinal}/imagens/{imagem}', [SinalController::class, 'destroyImage'])->name('sinais.imagens.destroy');
    Route::resource('sinais', SinalController::class)->parameters(['sinais' => 'sinal']);

    Route::post('/materiais/restore/{id}', [MaterialController::class, 'restore'])->name('materiais.restore');
    Route::delete('/materiais/force-delete/{id}', [MaterialController::class, 'forceDelete'])->name('materiais.force-delete');
    Route::get('/materiais/{material}/download', [MaterialController::class, 'download'])->name('materiais.download');
    Route::resource('materiais', MaterialController::class)->parameters(['materiais' => 'material']);
    
    Route::resource('logs', LogController::class)->only(['index', 'show']);

    Route::post('/users/restore/{id}', [UserController::class, 'restore'])->name('users.restore');
    Route::delete('/users/force-delete/{id}', [UserController::class, 'forceDelete'])->name('users.force-delete');
    Route::resource('users', UserController::class);
    
    Route::get('/ajuda', function () {
        return view('ajuda.index');
    })->middleware('auth')->name('ajuda.index');

});

require __DIR__.'/auth.php';
