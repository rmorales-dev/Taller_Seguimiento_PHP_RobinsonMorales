<?php

use App\Http\Controllers\WorkshopController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Taller Seguimiento PHP (Robinson Morales)
|--------------------------------------------------------------------------
*/

Route::get('/', [WorkshopController::class, 'index'])->name('workshop.index');

// Ejercicio 1: Lista de Tareas
Route::match(['get', 'post'], '/ejercicio-1', [WorkshopController::class, 'exercise1'])->name('workshop.exercise1');

// Ejercicio 2: Calculadora de Propinas
Route::match(['get', 'post'], '/ejercicio-2', [WorkshopController::class, 'exercise2'])->name('workshop.exercise2');
