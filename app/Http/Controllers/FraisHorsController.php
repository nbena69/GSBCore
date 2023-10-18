<?php

namespace App\Http\Controllers;

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
            // Calcul du montant total des frais hors forfait
            $fraisHorsForfait = FraisHors::all();
            $unServiceFraisHors = new ServiceFraisHors();
            $montantTotal = $unServiceFraisHors->calculerMontantTotalFraisHorsForfait($fraisHorsForfait);

            $mesFraisHors = $unServiceFraisHors->getFraisHors($id_fraisHors);

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

}
