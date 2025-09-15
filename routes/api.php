<?php

use Illuminate\Support\Facades\Route;
// routes/api.php
use App\Http\Controllers\Api\PropertyController;

Route::prefix('properties')->group(function () {
    // Rutas específicas primero
    Route::get('cities', [PropertyController::class, 'cities']);

    // Luego las rutas con parámetro
    Route::get('{property}', [PropertyController::class, 'show'])->whereNumber('property');
    Route::put('{property}', [PropertyController::class, 'update'])->whereNumber('property');
    Route::delete('{property}', [PropertyController::class, 'destroy'])->whereNumber('property');

    // index / store
    Route::get('/', [PropertyController::class, 'index']);
    Route::post('/', [PropertyController::class, 'store']);
});
