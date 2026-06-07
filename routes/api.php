<?php

use App\Http\Controllers\PlotController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/plots', [PlotController::class, 'index'])->name('api.plots.index');
    Route::patch('plots/{plot}/position', [PlotController::class, 'updatePosition'])->name('api.plots.position');
});
