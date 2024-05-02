<?php

use App\Http\Controllers\ActiviteController;
use App\Http\Controllers\FraisController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VisiteurController;
use App\Http\Controllers\FraisHorsController;

Route::get('/', function () {
    return view('home');
});

Route::get('/formLogin', [VisiteurController::class, 'getLogin']);
Route::post('/login', [VisiteurController::class, 'signIn']);

//Route::middleware('auth')->group(function () {
    Route::get('/getLogout', [VisiteurController::class, 'signOut']);

    Route::get('/getListeFrais', [FraisController::class, 'getFraisVisiteur']);
    Route::get('/listerFrais', [FraisController::class, 'getFraisVisiteur']);

    Route::get('/ajouterFrais', [FraisController::class, 'addFrais']);
    Route::get('/modifierFrais/{id}', [FraisController::class, 'updateFrais']);
    Route::post('/validerFrais', [FraisController::class, 'validateFrais']);
    Route::get('/supprimerFrais/{id}', [FraisController::class, 'supprimeFrais']);

    Route::get('/listeFraisHorsForfait/{id}', [FraisHorsController::class, 'getFraisVisiteurHorsForfait']);
    Route::get('/modifierFraisHorsForfait/{id}', [FraisHorsController::class, 'updateFraisHorsForfait']);
    Route::get('/ajouterFraisHorsForfait/{id}', [FraisHorsController::class, 'addFraisHorsForfait']);
    Route::post('/validerFraisHorsForfait', [FraisHorsController::class, 'validateFraisHorsForfait']);
    Route::get('/supprimerFraisHors/{id}',  [FraisHorsController::class, 'supprimeFraisHors']);

    //Activite Complémentaire
    Route::get('/ajouterActivite', [FraisController::class, 'addActivite']);
    Route::get('/getListeActivite', [ActiviteController::class, 'getActiviteVisiteur']);
    Route::get('/modifierActivite/{id}', [ActiviteController::class, 'updateActivite']);
    Route::post('/validerActivite', [ActiviteController::class, 'validateActivite']);
    Route::get('/supprimerActivite/{id}', [ActiviteController::class, 'supprimeActivite']);

    Route::get('/getFiltre', [VisiteurController::class, 'filtreVisiteurPage']);
    Route::get('/getResultatFiltre', [VisiteurController::class, 'filtreVisiteur']);
//});
