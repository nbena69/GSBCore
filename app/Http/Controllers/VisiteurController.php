<?php

namespace App\Http\Controllers;
use App\Exceptions\MonException;
use http\Client\Request;
use App\metier\Visiteur;
use App\dao\ServiceVisiteur;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;



class VisiteurController extends Controller
{
    public function getLogin(){
        try {
            $erreur = "";
            return view('vues.formLogin', compact('erreur'));
        } catch (MonException $e) {
            $erreur = $e->getMessage();
            return view('vues.formLogin', compact('erreur'));
        } catch (Exception $e) {
            $erreur = $e->getMessage();
            return view('vues.formLogin', compact('erreur'));
        }
    }



    public function signIn(){
        try {
            $login = Request::input('login');
            $pwd = Request::input('pwd');
            $unVisiteur = new ServiceVisiteur();
            $connected = $unVisiteur->login($login, $pwd);

            if($connected) {
                if (Session::get('type') === 'P') {
                    return view('vues/homePraticien');
                } else {
                    return view('home');
                }
            } else {
                $erreur = "Login ou mot de passe incorrect";
                return view('vues/formLogin', compact('erreur'));
            }
        } catch (MonException $e) {
            $erreur = $e->getMessage();
            return view('vues/formLogin', compact('erreur'));
        } catch (Exception $e) {
            $erreur = $e->getMessage();
            return view('vues/formLogin', compact('erreur'));
        }
    }


    public function signOut() {
        $unVisiteur = new ServiceVisiteur();
        $unVisiteur->logout();
        return view('home');
    }
}
