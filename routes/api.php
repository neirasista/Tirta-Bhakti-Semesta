<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SimulationController;
use App\Http\Controllers\VisitorController;

// =======================
// Public routes (customer)
// =======================
Route::get('catalogs', [CatalogController::class, 'index']);
Route::get('catalogs/{catalog}', [CatalogController::class, 'show']);

Route::get('portfolios', [PortfolioController::class, 'index']);
Route::get('portfolios/{portfolio}', [PortfolioController::class, 'show']);

Route::get('grades', [GradeController::class, 'index']);
Route::get('categories', [CategoryController::class, 'index']);

Route::post('simulation/run', [SimulationController::class, 'run']);
Route::get('simulation/{simulation}', [SimulationController::class, 'show']);

Route::post('visitors', [VisitorController::class, 'store']);
Route::get('visitors/count', [VisitorController::class, 'countUnique']);

Route::post('admin/login', [AdminAuthController::class, 'login']);


// =======================
// Protected routes (admin only)
// =======================
Route::middleware('auth:sanctum')->group(function() {
    Route::post('admin/logout', [AdminAuthController::class, 'logout']);

    Route::post('catalogs', [CatalogController::class, 'store']);
    Route::put('catalogs/{catalog}', [CatalogController::class, 'update']);
    Route::delete('catalogs/{catalog}', [CatalogController::class, 'destroy']);

    Route::post('portfolios', [PortfolioController::class, 'store']);
    Route::put('portfolios/{portfolio}', [PortfolioController::class, 'update']);
    Route::delete('portfolios/{portfolio}', [PortfolioController::class, 'destroy']);

    Route::apiResource('orders', OrderController::class);
    Route::apiResource('grades', GradeController::class)->except(['index']);
    Route::apiResource('categories', CategoryController::class)->except(['index']);

    Route::get('simulation/stats', [SimulationController::class, 'stats']);
    Route::get('simulations', [SimulationController::class, 'index']);
});
