<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\SongController;
use App\Http\Controllers\API\SuggestionController;
use Illuminate\Support\Facades\Route;

// Rotas públicas
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::get('songs', [SongController::class, 'index']);
Route::post('songs/{song}/increment-plays', [SongController::class, 'incrementPlays']);

// Rotas protegidas
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'user']);

    Route::post('suggestions', [SuggestionController::class, 'store']);

    // Rotas de administrador
    Route::middleware('admin')->group(function () {
        Route::apiResource('songs', SongController::class)->except('index');
        Route::get('suggestions', [SuggestionController::class, 'index']);
        Route::post('suggestions/{suggestion}/approve', [SuggestionController::class, 'approve']);
        Route::post('suggestions/{suggestion}/reject', [SuggestionController::class, 'reject']);
    });
});
