<?php

namespace App\Http\Controllers;

use App\dao\ServiceFraisHors;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use App\metier\FraisHors;
use App\Exceptions;
use App\Exceptions\MonException;
use function MongoDB\BSON\toRelaxedExtendedJSON;

class FraisHorsController extends Controller
{
    public function getFraisVisiteurHorsForfait($id_frais)
    {
        try {
            $erreur = "";
            $monErreur = Session::get('monErreur');
            Session::forget('monErreur');
            $unServiceFrais = new ServiceFraisHors();
            $id_visiteur = Session::get('id');
            $mesFrais = $unServiceFrais->getFraisHorsForfait($id_frais);
            $montantTotal = $unServiceFrais->getMontantTotalFraisHorsForfait($id_frais);
            return view('vues/listeFraisHorsForfait', compact('mesFrais', 'montantTotal', 'erreur'));
        } catch (MonException$e) {
            $erreur = $e->getMessage();
            return view('vues/error', compact('erreur'));
        } catch (Exception$e) {
            $erreur = $e->getMessage();
            return view('vues/error', compact('erreur'));
        }
    }


    public function updateFraisHorsForfait($id_fraisfraishorsforfait)
    {
        try {
            $monErreur = "";
            $erreur = "";
            $unServiceFrais = new ServiceFraisHors;
            $unFrais = $unServiceFrais->getByIdFraisHorsForfait($id_fraisfraishorsforfait);
            $titrevue = "Modification d'une fiche de frais hors Forfait";
            return view('vues/formFraisHorsForfait', compact('unFrais', 'titrevue', 'erreur'));
        } catch (MonException $e) {
            $erreur = $e->getMessage();
            return view('vues/error', compact('erreur'));
        } catch (Exception $e) {
            $erreur = $e->getMessage();
            return view('vues/error', compact('erreur'));
        }
    }


    public function validateFraisHorsForfait()
    {
        try {
            $erreur = "";
            $id_fraishorsforfait = Request::input('id_fraishorsforfait');
            if(Request::input('id_frais') != null || Request::input('id_frais') != "null") {
                $id_frais = 1;
            } else{
                $id_frais = Request::input('id_frais');

            }
            $lib_fraishorsforfait = Request::input('lib_fraishorsforfait');
            $date_fraishorsforfait = Request::input('date_fraishorsforfait');
            $montant_fraishorsforfait = Request::input('montant_fraishorsforfait');

            $unServiceFrais = new ServiceFraisHors();
            if ($id_fraishorsforfait > 0) {
                $unServiceFrais->updateFraisHorsForfait($id_frais, $date_fraishorsforfait, $montant_fraishorsforfait, $lib_fraishorsforfait);
            } else {
                $montant = Request::input('montant');
                $id_visiteur = Session::get('id');
                $unServiceFrais->insertFraisHorsForfait($id_frais, $date_fraishorsforfait, $montant_fraishorsforfait, $lib_fraishorsforfait);
            }

            $montant_fraishorsforfait = Request::input('montant_fraishorsforfait');

            $mesFrais = $unServiceFrais->getFraisHorsForfait($id_frais);
            return view('/home', compact('mesFrais', 'montant_fraishorsforfait'));
        } catch (MonException $e) {
            $erreur = $e->getMessage();
            return view('vues/error', compact('erreur'));
        } catch (Exception $e) {
            $monErreur = $e->getMessage();
            return view('vues/error', compact('erreur'));
        }
    }


    public function addFraisHorsForfait($id_frais)
    {
        try {
            $erreur = "";
            $titrevue = "Ajout d'une fiche de Frais";
            $id_visiteur = Session::get('id');

            $unServiceFrais = new ServiceFraisHors;
            $mesFrais = $unServiceFrais->getFraisHorsForfait($id_frais);
            return view('vues/formAjoutFraisHorsForfait', compact('mesFrais', 'titrevue', 'erreur', 'id_visiteur'));
        } catch (MonException $e) {
            $erreur = $e->getMessage();
            return view('vues/error', compact('erreur'));
        } catch (Exception $e) {
            $erreur = $e->getMessage();
            return view('vues/error', compact('erreur'));
        }
    }


    public function supprimeFraisHors($id_fraisHors)
    {
        $unServiceFraisHors = new ServiceFraisHors();

        try {
            $unServiceFraisHors->deleteFraisHors($id_fraisHors);
        } catch (MonException $e) {
            $erreur = $e->getMessage();
        } catch (Exception $e) {
            $erreur = $e->getMessage();
        } finally {
            if (isset($erreur)) {
                Session::put('erreur', 'Impossible de supprimer une fiche ayant des Frais Hors forfait');
            }
            return redirect('/getListeFrais');
        }
    }


    public function __construct()
    {
        $this->id_frais = 0;
    }
}
