<?php

namespace App\Http\Controllers;

use App\dao\ServiceFrais;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use App\metier\Frais;
use App\Exceptions;
use App\Exceptions\MonException;
use function MongoDB\BSON\toRelaxedExtendedJSON;

class FraisController extends Controller
{

    public function getFraisVisiteur()
    {
        try {
            $erreur = "";
            $monErreur = Session::get('monErreur');
            Session::forget('monErreur');
            $unServiceFrais = new ServiceFrais();
            $id_visiteur = Session::get('id');
            $mesFrais = $unServiceFrais->getFrais($id_visiteur);
            return view('vues/listeFrais', compact('mesFrais', 'erreur'));
        } catch (MonException$e) {
            $erreur = $e->getMessage();
            return view('vues/error', compact('erreur'));
        } catch (Exception$e) {
            $erreur = $e->getMessage();
            return view('vues/error', compact('erreur'));
        }
    }


    public function updateFrais($id_frais)
    {
        try {
            $monErreur = "";
            $erreur = "";
            $unServiceFrais = new ServiceFrais;
            $unFrais = $unServiceFrais->getById($id_frais);
            $titrevue = "Modification d'une fiche de Frais";
            return view('vues/formFrais', compact('unFrais', 'titrevue', 'erreur'));
        } catch (MonException $e) {
            $erreur = $e->getMessage();
            return view('vues/error', compact('erreur'));
        } catch (Exception $e) {
            $erreur = $e->getMessage();
            return view('vues/error', compact('erreur'));
        }
    }


    public function validateFrais()
    {
        try {
            $erreur = "";

            $id_frais = Request::input('id_frais');
            $anneemois = Request::input('anneemois');
            $nbjustificatifs = Request::input('nbjustificatifs');
            $unServiceFrais = new ServiceFrais();
            if ($id_frais > 0) {
                $unServiceFrais->updateFrais($id_frais, $anneemois, $nbjustificatifs);
            } else {
                $montant = Request::input('montant');
                $id_visiteur = Session::get('id');
                $unServiceFrais->insertFrais($anneemois, $nbjustificatifs, $id_visiteur, $montant);
            }
            return redirect('/getListeFrais');
        } catch (MonException $e) {
            $erreur = $e->getMessage();
            return view('vues/error', compact('erreur'));
        } catch (Exception $e) {
            $erreur = $e->getMessage();
            return view('vues/error', compact('erreur'));
        }
    }


    public function addFrais()
    {
        try {
            $erreur = "";
            $titrevue = "Ajout d'une fiche de Frais";
            $id_visiteur = Session::get('id');
            $unServiceFrais = new ServiceFrais;
            $mesFrais = $unServiceFrais->getFrais($id_visiteur);
            return view('vues/formAjoutFrais', compact('mesFrais', 'titrevue', 'erreur', 'id_visiteur'));
        } catch (MonException $e) {
            $erreur = $e->getMessage();
            return view('vues/error', compact('erreur'));
        } catch (Exception $e) {
            $erreur = $e->getMessage();
            return view('vues/error', compact('erreur'));
        }
    }


    public function supprimeFrais($id_frais)
    {
        try {
            $erreur = "";
            $unServiceFrais = new ServiceFrais();
            $unServiceFrais->deleteFrais($id_frais);
            $id_visiteur = Session::get('id');
            $unServiceFrais = new ServiceFrais;
            $mesFrais = $unServiceFrais->getFrais($id_visiteur);
            return view('vues/listeFrais', compact('mesFrais', 'erreur', 'id_visiteur'));
            //return redirect('/getListeFrais', compact('erreur'));
        } catch (MonException $e) {
            $id_visiteur = Session::get('id');
            $unServiceFrais = new ServiceFrais;
            $mesFrais = $unServiceFrais->getFrais($id_visiteur);
            $erreur = "Impossible de supprimer une fiche ayant des Frais Hors Forfait !";

            return view('vues/listeFrais', compact('mesFrais', 'erreur', 'id_visiteur'));
        } catch (Exception $e) {
            //$erreur = $e->getMessage();
            Session::put('erreur', 'Impossible de supprimer une fiche ayant des Frais Hors Forfait !');
            //return view('Vues/error', compact('erreur'));
            $id_visiteur = Session::get('id');
            $unServiceFrais = new ServiceFrais;
            $mesFrais = $unServiceFrais->getFrais($id_visiteur);
            return view('vues/listeFrais', compact('mesFrais', 'erreur', 'id_visiteur'));
        }
    }


    public function __construct()
    {
        $this->id_frais = 0;
    }
}
