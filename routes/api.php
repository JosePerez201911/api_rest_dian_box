<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CompaniaController;
use App\Http\Controllers\Api\FacturaController;
use App\Http\Controllers\Api\NotaCreditoController;
use App\Http\Controllers\Api\DocumentoSoporteController;
use App\Http\Controllers\Api\NominaController;



/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');*/

//Route::post('/companias', [CompaniaController::class, 'store']);
Route::post('/factura', [FacturaController::class, 'store']);
/*
Route::post('/notacredito', [NotaCreditoController::class, 'store']);
Route::post('/documentosoporte', [DocumentoSoporteController::class, 'store']);
Route::post('/nomina', [NominaController::class, 'store']);*/



