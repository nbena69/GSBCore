<?php

namespace App\Http\Controllers;
use App\Exceptions\MonException;
use Request;
use App\metier\Visiteur;
class VisiteurController extends Controller
{
    public function getLogin(){
        try {
            $erreur = "";
            return view ('vues/formLogin', compact('erreur'));
        } catch (MonException $e) {
            $monErreur = $e->getMessage();
            return view('vues/formLogin', compact('erreur'));
        } catch (Exception $e) {
            $monErreur = $e->getMessage();
            return view('vues/formLogin', compact('erreur'));
        }
    }

    /**
     *Authentifie le visiteur
     * @return type Vue formLogin ou home
     */
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
            $monErreur = $e->getMessage();
            return view('vues/formLogin', compact('erreur'));
        } catch (Exception $e) {
            $monErreur = $e->getMessage();
            return view('vues/formLogin', compact('erreur'));
        }
    }

    /**
     * Déconnecte le visiteur authentifié
     * @return type Vue home
     */
    public function signOut() {
        $unVisiteur = new ServiceVisiteur();
        $unVisiteur->logout();
        return view('home');
    }
}
