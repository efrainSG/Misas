<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocacionController;
use App\Http\Controllers\CiudadController;
use App\Http\Controllers\ColoniaController;
use App\Http\Controllers\HorarioController;

Route::get('/locaciones', [LocacionController::class, 'getAll']);
Route::get('/locaciones/{id}', [LocacionController::class, 'getById']);
Route::get('/locaciones/nombre/{nombre}', [LocacionController::class, 'getByNombre']);
Route::get('/locaciones/colonia/{coloniaId}', [LocacionController::class, 'getByColoniaId']);
Route::get('/locaciones/tipo/{tipoLocacionId}', [LocacionController::class, 'getByTipoLocacionId']);
Route::get('/locaciones/{id}/horarios', [LocacionController::class, 'getHorariosByLocacionId']);
Route::post('/locaciones', [LocacionController::class, 'create']);

Route::get('/ciudades', [CiudadController::class, 'getAll']);
Route::get('/ciudades/{id}', [CiudadController::class, 'getById']);
Route::get('/ciudades/nombre/{nombre}', [CiudadController::class, 'getByNombre']);

Route::get('/colonias', [ColoniaController::class, 'getAll']);
Route::get('/colonias/{id}', [ColoniaController::class, 'getById']);
Route::get('/colonias/nombre/{nombre}', [ColoniaController::class, 'getByNombre']);
Route::get('/colonias/ciudad/{ciudadId}', [ColoniaController::class, 'getByCiudadId']);

Route::get('/horarios', [HorarioController::class, 'getAll']);
Route::get('/horarios/{id}', [HorarioController::class, 'getById']);
Route::get('/horarios/hora/{hora}', [HorarioController::class, 'getByHora']);
Route::get('/horarios/diaSemana/{diaSemana}', [HorarioController::class, 'getByDiaSemana']);
Route::get('/horarios/activo/{activo}', [HorarioController::class, 'getByActivo']);
Route::get('/horarios/locacion/{locacionId}', [HorarioController::class, 'getByLocacionId']);