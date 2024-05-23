<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiciosController;
use App\Http\Controllers\PacientesController;
use App\Http\Controllers\turnosController; 

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pacientes', [PacientesController::class, 'index']);
Route::get('/servicios', [ServiciosController::class, 'index']);
//Route::post('/servicios', [ServiciosController::class, 'guardar']);
Route::post('/turnos', [turnosController::class, 'guardar']); 
Route::get('/turnos', [turnosController::class, 'index']); 
Route::put('/turnos/{id}', [turnosController::class, 'actualizar']); 
Route::delete('/turnos/{id}', [turnosController::class, 'eliminar']); 
