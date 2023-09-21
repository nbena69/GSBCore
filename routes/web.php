<?php

use Illuminate\Support\Facades\Route;

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
    $nael = 2;
    return view('home');
});

Route::get('/formLogin', [VisiteurController::class, 'getLogin']);
Route::get('/login', [VisiteurController::class, 'signIn']);
Route::get('/getLogout', [VisiteurController::class, 'signOut']);
