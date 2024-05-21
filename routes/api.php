<?php

use App\Http\Controllers\ActiviteWSController;
use App\Http\Controllers\AffectationWSController;
use App\Http\Controllers\FraisHorsForfaitWSController;
use App\Http\Controllers\FraisWSController;
use App\Http\Controllers\PraticienWSController;
use App\Http\Controllers\ShortWSController;
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

// api
Route::middleware('auth:sanctum')->prefix('frais')->group(function () {
    Route::get('', [FraisWSController::class, "liste"]);
    Route::get('getUnFrais/{id}', [FraisWSController::class, "detail"]);
    Route::get('visiteur/{id_visiteur}', [FraisWSController::class, "fraisVisiteur"]);
    Route::post('ajoutFrais', [FraisWSController::class, "ajoutFrais"]);
    Route::put('updateFrais/{id}', [FraisWSController::class, 'updateFrais']);
    Route::delete('deleteFrais/{id}', [FraisWSController::class, 'deleteFrais']);
    Route::get('mois/{mois}', [FraisWSController::class, 'fraisMois']);
    Route::get('moisMontant/{mois}', [FraisWSController::class, 'fraisMoisMontant']);
    Route::get('visiteurSansFrais', [FraisWSController::class, 'visiteurSansFrais']);
    Route::get('nombreFraisHF', [FraisWSController::class, 'nombreFraisHF']);
});

Route::middleware('auth:sanctum')->prefix('activite')->group(function () {
    Route::get('', [ActiviteWSController::class, "liste"]);
    Route::get('getUneActivite/{id}', [ActiviteWSController::class, "detail"]);
    Route::get('visiteur/{id}', [ActiviteWSController::class, "activiteVisiteur"]);
    Route::get('praticien/{id}', [ActiviteWSController::class, "activitePraticien"]);
    Route::post('ajoutActivite', [ActiviteWSController::class, "ajoutActivite"]);
    Route::put('updateActivite/{id}', [ActiviteWSController::class, 'updateActivite']);
    Route::delete('deleteActivite/{id}', [ActiviteWSController::class, 'deleteActivite']);
});

Route::middleware('auth:sanctum')->prefix('fraishorsforfait')->group(function () {
    Route::get('', [FraisHorsForfaitWSController::class, "liste"]);
    Route::get('getUnFraisHorsForfait/{id}', [FraisHorsForfaitWSController::class, "detail"]);
    Route::get('/{id_frais}', [FraisHorsForfaitWSController::class, "listeParFrais"]);
    Route::post('ajoutFraisHorsForfait', [FraisHorsForfaitWSController::class, "ajoutFraisHorsForfait"]);
    Route::put('updateFraisHorsForfait/{id}', [FraisHorsForfaitWSController::class, "updateFraisHorsForfait"]);
    Route::delete('deleteFraisHorsForfait/{id}', [FraisHorsForfaitWSController::class, "deleteFraisHorsForfait"]);
});

Route::middleware('auth:sanctum')->prefix('visiteur')->group(function () {
    Route::get('', [VisiteurWSController::class, "liste"]);
    Route::get('getUnVisiteur/{id_visiteur}', [VisiteurWSController::class, "details"]);
    Route::get('ville/{ville_visiteur}', [VisiteurWSController::class, "visiteurVille"]);
    Route::get('nom/{nom_visiteur}', [VisiteurWSController::class, "visiteurNom"]);
    Route::delete('deleteVisiteur/{id}', [VisiteurWSController::class, 'deleteVisiteur']);
    Route::put('updateVisiteur/{id}', [VisiteurWSController::class, 'updateVisiteur']);
    Route::get('filtreAffectation', [VisiteurWSController::class, "filtreAffectation"]);
    Route::get('filtreAffectAvancee', [VisiteurWSController::class, "filtreAffectAvancee"]);
});

Route::middleware('auth:sanctum')->prefix('praticien')->group(function () {
    Route::get('ville/{ville_visiteur}', [PraticienWSController::class, "praticienVille"]);
});

Route::middleware('auth:sanctum')->prefix('affectation')->group(function () {
    Route::get('', [AffectationWSController::class, "liste"]);
    Route::get('affectationVisiteur/{id_visiteur}', [AffectationWSController::class, "affectationVisiteur"]);
    Route::get('affectationUnique/{id_travail}', [AffectationWSController::class, "affectationUnique"]);
    Route::post('ajoutAffectation', [AffectationWSController::class, "ajoutAffectation"]);
    Route::put('updateAffectation/{id}', [AffectationWSController::class, "updateAffectation"]);
    Route::delete('deleteAffectation/{id}', [AffectationWSController::class, "deleteAffectation"]);
});

//auth
Route::post('getConnexion', [VisiteurWSController::class, "getConnexion"]);
Route::post('ajoutVisiteur', [VisiteurWSController::class, "ajoutVisiteur"]);
Route::post('login', [VisiteurWSController::class, "login"]);
Route::get('logout', [VisiteurWSController::class, "logout"])->middleware('auth:sanctum');
Route::get('updatePassword', [VisiteurWSController::class,"updatePassword"])->middleware('auth:sanctum');

//divers
Route::get('etats', [ShortWSController::class, "listeEtats"]);
Route::get('laboratoire', [ShortWSController::class, "listeLaboratoire"]);
Route::get('secteur', [ShortWSController::class, "listeSecteur"]);
Route::get('region', [ShortWSController::class, "listeRegion"]);
Route::get('specialite', [ShortWSController::class, "listeSpecialite"]);
Route::get('region-secteur', [ShortWSController::class, "listeRegionSecteur"]);
