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

    public function getPraticien($id_activite)
    {
        try {
            $erreur = "";
            $monErreur = Session::get('monErreur');
            Session::forget('monErreur');
            $unServiceActivite = new ServiceActivite();
            $mesPraticiens = $unServiceActivite->getAllPraticien();
            return view('vues/activite/listePraticienInvitation', compact('mesPraticiens', 'erreur', 'id_activite'));
        } catch (MonException$e) {
            $erreur = $e->getMessage();
            return view('vues/error', compact('erreur'));
        } catch (Exception$e) {
            $erreur = $e->getMessage();
            return view('vues/error', compact('erreur'));
        }
    }

    public function addActivite()
    {
        try {
            $erreur = "";
            $titrevue = "Ajout d'une Activite";
            $id_visiteur = Session::get('id');
            $unServiceActivite = new ServiceActivite();
            $mesActivites = $unServiceActivite->getActivite($id_visiteur);
            return view('vues/activite/formAjoutActivite', compact('mesActivites', 'titrevue', 'erreur', 'id_visiteur'));
        } catch (MonException $e) {
            $erreur = $e->getMessage();
            return view('vues/error', compact('erreur'));
        } catch (Exception $e) {
            $erreur = $e->getMessage();
            return view('vues/error', compact('erreur'));
        }
    }

    public function addPraticien($id, $id_praticien)
    {
        try {
            $erreur = "";
            $unServiceActivite = new ServiceActivite();
            $unServiceActivite->insertPraticien($id, $id_praticien);
            return $this->updateActivite($id);
        } catch (MonException $e) {
            $erreur = $e->getMessage();
            return view('vues/error', compact('erreur'));
        } catch (Exception $e) {
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
            $mesPraticien = $unServiceActivite->getInviter($id_activite);
            return view('vues/activite/formActivite', compact('uneActivite', 'mesPraticien', 'titrevue', 'erreur'));
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
            $id_visiteur = Session::get('id');
            $id_activite = Request::input('id_activite');
            $date_activite = Request::input('date_activite');
            $lieu_activite = Request::input('lieu_activite');
            $theme_activite = Request::input('theme_activite');
            $motif_activite = Request::input('motif_activite');
            $unServiceActivite = new ServiceActivite();
            if ($id_activite > 0) {
                $unServiceActivite->updateActivite($id_activite, $date_activite, $lieu_activite, $theme_activite, $motif_activite);
            } else {
                $unServiceActivite->insertActivite($id_visiteur, $date_activite, $lieu_activite, $theme_activite, $motif_activite);
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
            $id_visiteur = Session::get('id');
            $unServiceActivite = new ServiceActivite();
            $unServiceActivite->deleteActivite($id_activite, $id_visiteur);
            $mesActivites = $unServiceActivite->getActivite($id_visiteur);
            return view('vues/activite/listeActivite', compact('mesActivites', 'erreur', 'id_visiteur'));
        } catch (MonException $e) {
            $erreur = $e->getMessage();
            return view('vues/error', compact('erreur'));
        } catch (Exception $e) {
            $erreur = $e->getMessage();
            return view('vues/error', compact('erreur'));
        }
    }

    public function supprimeInviter($id_praticien, $id_activite)
    {
        try {
            $erreur = "";
            $id_visiteur = Session::get('id');
            $unServiceActivite = new ServiceActivite();
            $unServiceActivite->deleteInviter($id_praticien);
            $mesActivites = $unServiceActivite->getActivite($id_visiteur);
            return $this->updateActivite($id_activite);
        } catch (MonException $e) {
            $erreur = $e->getMessage();
            return view('vues/error', compact('erreur'));
        } catch (Exception $e) {
            $erreur = $e->getMessage();
            return view('vues/error', compact('erreur'));
        }
    }
}
