<?php

namespace App\Http\Controllers;

use App\dao\ServiceFrais;
use App\Exceptions\MonException;
use App\metier\FraisHors;
use App\Models\User;
use App\dao\ServiceFraisHors;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;


class FraisHorsController extends Controller
{
    public function getFraisHors($id_fraisHors)
    {
        try {
            $unServiceFraisHors = new ServiceFraisHors();

            $fraisHorsForfait = FraisHors::all();

            $montantTotal = $unServiceFraisHors->calculerMontantTotalFraisHorsForfait($fraisHorsForfait, $id_fraisHors);

            $mesFraisHors = $fraisHorsForfait->where('id_frais', $id_fraisHors);

            return view('vues/listeFraisHors', compact('mesFraisHors', 'montantTotal'));
        } catch (MonException $e) {
            $erreur = $e->getMessage();
            return view('vues/error', compact('erreur'));
        } catch (Exception $e) {
            $erreur = $e->getMessage();
            return view('vues/error', compact('erreur'));
        }
    }


    public function addFraisHors($id_frais)
    {
        try {
            $erreur = '';
            $unFraisHors = "";

            $titreVue = "Ajout d'une fiche de Frais Hors Forfait";
            return view('vues/formFraisHors', compact('unFraisHors', 'titreVue', 'erreur', 'id_frais'));
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

    public function validateFraisHors($id_frais)
    {
        try {
            $id_frais = Request::input('id_frais');
            $date = Request::input('date_fraishorsforfait');
            $montant = Request::input('montant_fraishorsforfait');
            $libelle = Request::input('lib_fraishorsforfait');
            $unServiceFraisHors = new ServiceFraisHors();
            $unServiceFraisHors->insertFraisHors($id_frais, $date, $montant, $libelle);
            return redirect($this->getFraisHors($id_frais));
        } catch (MonException $e) {
            $erreur = $e->getMessage();
            return view('vues/error', compact('erreur'));
        } catch (Exception $e) {
            $erreur = $e->getMessage();
            return view('vues/error', compact('erreur'));
        }
    }
}
