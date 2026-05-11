<?php

use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\VoitureController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Routes principales
Route::apiResource('categories', CategorieController::class)
    ->parameters([
        'categories' => 'categorie'
    ]);
Route::apiResource('clients', ClientController::class);
Route::apiResource('voitures', VoitureController::class);
Route::apiResource('reservations', ReservationController::class);
Route::apiResource('paiements', PaiementController::class);

// Routes imbriquées
Route::get('clients/{client}/reservations', [ClientController::class, 'reservations']);
Route::get('voitures/{voiture}/reservations', [VoitureController::class, 'reservations']);
Route::get('categories/{categorie}/voitures', [CategorieController::class, 'voitures']);
