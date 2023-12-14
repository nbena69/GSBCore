<?php

use App\Http\Controllers\FraisWSController;
use App\Http\Controllers\VisiteurWSController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// http://localhost:8000/api/
Route::prefix('frais')->group(function () {
    Route::get('', [FraisWSController::class, "liste"]);
    Route::get('getUnFrais', [FraisWSController::class, "detail"]);
    Route::get('visiteur/{id_visiteur}', [FraisWSController::class, "fraisVisiteur"]);
    Route::post('ajoutFrais', [FraisWSController::class, "ajoutFrais"]);
    Route::put('updateFrais/{id}', [FraisWSController::class, 'updateFrais']);
    Route::delete('deleteFrais/{id}', [FraisWSController::class, 'deleteFrais']);
    Route::get('mois/{mois}', [FraisWSController::class, 'fraisMois']);
    Route::get('moisMontant/{mois}', [FraisWSController::class, 'fraisMoisMontant']);
    Route::get('visiteurSansFrais', [FraisWSController::class, 'visiteurSansFrais']);
    Route::get('nombreFraisHF', [FraisWSController::class, 'nombreFraisHF']);
});

Route::prefix('visiteur')->group(function () {
    Route::get('', [VisiteurWSController::class, "liste"]);
    Route::get('ville/{ville_visiteur}', [VisiteurWSController::class, "visiteurVille"]);
    Route::get('nom/{nom_visiteur}', [VisiteurWSController::class, "visiteurNom"]);
    Route::post('ajoutVisiteur', [VisiteurWSController::class, "ajoutVisiteur"]);
    Route::delete('deleteVisiteur/{id}', [VisiteurWSController::class, 'deleteVisiteur']);
    Route::put('updateVisiteur/{id}', [VisiteurWSController::class, 'updateVisiteur']);
});

//auth
Route::post('getConnexion', [VisiteurWSController::class, "getConnexion"]);
Route::get('updatePassword', [VisiteurWSController::class,"updatePassword"]);
Route::post('login', [VisiteurWSController::class, "login"]);
Route::get('logout', [VisiteurWSController::class, "logout"])->middleware('auth:sanctum');
