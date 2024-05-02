<?php

namespace App\Http\Controllers;

use App\dao\ServiceActivite;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use App\Exceptions;
use App\Exceptions\MonException;

class ActiviteController extends Controller
{
    public function getActiviteVisiteur()
    {
        try {
            $erreur = "";
            $monErreur = Session::get('monErreur');
            Session::forget('monErreur');
            $unServiceActivite = new ServiceActivite();
            $id_visiteur = Session::get('id');
            $mesActivites = $unServiceActivite->getActivite($id_visiteur);
            return view('vues/activite/listeActivite', compact('mesActivites', 'erreur'));
        } catch (MonException$e) {
            $erreur = $e->getMessage();
            return view('vues/error', compact('erreur'));
        } catch (Exception$e) {
            $erreur = $e->getMessage();
            return view('vues/error', compact('erreur'));
        }
    }
}



