<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\Api\ComputadorController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\CategoriaController;


Route::get('/ventas', [VentaController::class, 'index'])->name('ventas.index');
Route::post('/ventas', [VentaController::class, 'create'])->name('ventas.create');
Route::get('/ventas/exportar', [VentaController::class, 'exportarPdf'])->name('ventas.exportar');

Route::get('/empleados', [EmpleadoController::class, 'index'])->name('empleados.index');
Route::post('/empleados', [EmpleadoController::class, 'create'])->name('empleados.create');
Route::get('/empleados/exportar', [EmpleadoController::class, 'exportarPdf'])->name('empleados.exportar');

Route::get('/computadores', [ComputadorController::class, 'index'])->name('computadores.index');
Route::get('/computadores/exportar', [ComputadorController::class, 'exportarPdf'])->name('computadores.exportar');
Route::post('/computadores/store', [ComputadorController::class, 'store'])->name('computadores.store');
Route::get('/computadores/{id}', [ComputadorController::class, 'show'])->name('computadores.show');
Route::put('/computadores/{id}', [ComputadorController::class, 'update'])->name('computadores.update');
Route::delete('/computadores/{id}', [ComputadorController::class, 'destroy'])->name('computadores.destroy');


Route::get('/', [FrontController::class, 'index'])->name('dashboard.index');
Route::get('/dashboard', [FrontController::class, 'index'])->name('dashboard.index');

Route::resource('categorias', App\Http\Controllers\CategoriaController::class);
Route::get('/categorias/activas', [CategoriaController::class, 'activasConComputadores']);

