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

// Ejercicio 3: Generador de Contraseñas
Route::match(['get', 'post'], '/ejercicio-3', [WorkshopController::class, 'exercise3'])->name('workshop.exercise3');

// Ejercicio 4: Gestor de Gastos
Route::match(['get', 'post'], '/ejercicio-4', [WorkshopController::class, 'exercise4'])->name('workshop.exercise4');

// Ejercicio 5: Sistema de Reservas
Route::match(['get', 'post'], '/ejercicio-5', [WorkshopController::class, 'exercise5'])->name('workshop.exercise5');

// Ejercicio 6: Gestor de Notas
Route::match(['get', 'post'], '/ejercicio-6', [WorkshopController::class, 'exercise6'])->name('workshop.exercise6');

// Ejercicio 7: Calendario de Eventos
Route::match(['get', 'post'], '/ejercicio-7', [WorkshopController::class, 'exercise7'])->name('workshop.exercise7');

// Ejercicio 8: Plataforma de Recetas
Route::match(['get', 'post'], '/ejercicio-8', [WorkshopController::class, 'exercise8'])->name('workshop.exercise8');

// Ejercicio 9: Juego de Memoria
Route::get('/ejercicio-9', [WorkshopController::class, 'exercise9'])->name('workshop.exercise9');

// Ejercicio 11: Cronómetro Online
Route::get('/ejercicio-11', [WorkshopController::class, 'exercise11'])->name('workshop.exercise11');
