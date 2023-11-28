<?php

use App\Http\Controllers\FraisController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VisiteurController;
use App\Http\Controllers\FraisHorsController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return view('home');
});

Route::get('/formLogin', [VisiteurController::class, 'getLogin']);
Route::post('/login', [VisiteurController::class, 'signIn']);
Route::get('/getLogout', [VisiteurController::class, 'signOut']);


Route::get('/getListeFrais', [FraisController::class, 'getFraisVisiteur']);
Route::get('/listerFrais', [FraisController::class, 'getFraisVisiteur']);


Route::get('/modifierFrais/{id}', [FraisController::class, 'updateFrais']);
Route::post('/validerFrais', [FraisController::class, 'validateFrais']);


Route::get('/ajouterFrais', [FraisController::class, 'addFrais']);
Route::post('/validerFrais', [FraisController::class, 'validateFrais']);

Route::get('/supprimerFrais/{id}', [FraisController::class, 'supprimeFrais']);

//Frais Hors Forfait
Route::get('/listeFraisHorsForfait/{id}', [FraisHorsController::class, 'getFraisVisiteurHorsForfait']);

Route::get('/modifierFraisHorsForfait/{id}', [FraisHorsController::class, 'updateFraisHosForfait']);
Route::post('/validerFraisHorsForfait', [FraisHorsController::class, 'validateFraisHorsForfait']);

Route::get('/ajouterFraisHorsForfait/{id}', [FraisHorsController::class, 'addFraisHorsForfait']);
Route::post('/validerFraisHorsForfait/{id}', [FraisHorsController::class, 'validateFraisHorsForfait']);
Route::get('/supprimerFraisHors/{id}',  [FraisHorsController::class, 'supprimeFraisHors']);
