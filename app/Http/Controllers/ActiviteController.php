<?php

namespace App\Http\Controllers;

use App\dao\ServiceActivite;
use Exception;
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

    public function updateActivite($id_activite)
    {
        try {
            $monErreur = "";
            $erreur = "";
            $unServiceActivite = new ServiceActivite();
            $uneActivite = $unServiceActivite->getById($id_activite);
            $titrevue = "Modification d'une Activite";
            return view('vues/activite/formActivite', compact('uneActivite', 'titrevue', 'erreur'));
        } catch (MonException $e) {
            $erreur = $e->getMessage();
            return view('vues/error', compact('erreur'));
        } catch (Exception $e) {
            $erreur = $e->getMessage();
            return view('vues/error', compact('erreur'));
        }
    }

    public function validateActivite()
    {
        try {
            $erreur = "";
            $id_activite = Request::input('id_activite');
            $date_activite = Request::input('date_activite');
            $lieu_activite = Request::input('lieu_activite');
            $theme_activite = Request::input('theme_activite');
            $motif_activite = Request::input('motif_activite');
            $unServiceActivite = new ServiceActivite();
            if ($id_activite > 0) {
                $unServiceActivite->updateActivite($id_activite, $date_activite, $lieu_activite, $theme_activite, $motif_activite);
            } else {
                $unServiceActivite->insertActivite($date_activite, $lieu_activite, $theme_activite, $motif_activite);
            }
            return redirect('/getListeActivite');
        } catch (MonException $e) {
            $erreur = $e->getMessage();
            return view('vues/error', compact('erreur'));
        } catch (Exception $e) {
            $erreur = $e->getMessage();
            return view('vues/error', compact('erreur'));
        }
    }

    public function supprimeActivite($id_activite)
    {
        try {
            $erreur = "";
            $unServiceActivite = new ServiceActivite();
            $unServiceActivite->deleteActivite($id_activite);
            $id_visiteur = Session::get('id');
            $unServiceActivite = new ServiceActivite();
            $mesActivite = $unServiceActivite->getActivite($id_visiteur);
            return view('vues/activite/listeActivite', compact('mesActivite', 'erreur', 'id_visiteur'));
        } catch (MonException $e) {
            $erreur = $e->getMessage();
            return view('vues/error', compact('erreur'));
        } catch (Exception $e) {
            $erreur = $e->getMessage();
            return view('vues/error', compact('erreur'));
        }
    }
}
