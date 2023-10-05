<?php

namespace App\Http\Controllers;

use App\Exceptions\MonException;
use App\metier\Frais;
use App\dao\ServiceFrais;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;


class FraisController extends Controller
{
    public function getFraisVisiteur()
    {
        try {


            $erreur = Session::get('monErreur');
            Session::forget('monErreur');
            $unServiceFrais = new ServiceFrais();
            $id_visiteur = Session::get('id');
            $mesFrais = $unServiceFrais->getFrais($id_visiteur);
            return view('vues/listeFrais', compact('mesFrais', 'erreur'));
        } catch (MonException $e) {
            $erreur = $e->getMessage();
            return view('vues/error', compact('erreur'));
        } catch (Exception $e) {
            $erreur = $e->getMessage();
            return view('vues/error', compact('erreur'));
        }
    }

    public function updateFrais($id_frais)
    {
        try {
            $erreur = "";
            $unServiceFrais = new ServiceFrais();
            $unFrais = $unServiceFrais->getById($id_frais);
            $titreVue = "Modification d'une fiche de frais";
            return view('vues/formFrais', compact('unFrais', 'titreVue', 'erreur'));
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
            $erreur = '';
            $unFrais = "";
            $titreVue = "Ajout d'une fiche de Frais";
            return view('Vues/formFrais', compact('unFrais', 'titreVue', 'erreur'));
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
}
