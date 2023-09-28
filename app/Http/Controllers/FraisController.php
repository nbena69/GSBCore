<?php

namespace App\Http\Controllers;

use App\Exceptions\MonException;
use Request;
use App\metier\Frais;
use App\dao\ServiceFrais;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class FraisController extends Controller
{
    public function getFraisVisiteur()
    {
        try {


            $monErreur = Session::get('monErreur');
            Session::forget('monErreur');
            $unServiceFrais = new ServiceFrais();
            $id_visiteur = Session::get('id');
            $mesFrais = $unServiceFrais->getFrais($id_visiteur);
            return view('vues/listeFrais', compact('mesFrais', 'monErreur'));
        } catch (MonException $e) {
            $monErreur = $e->getMessage();
            return view('vues/error', compact('monErreur'));
        } catch (Exception $e) {
            $monErreur = $e->getMessage();
            return view('vues/error', compact('monErreur'));
        }
    }

    public function updateFrais($id_frais) {
        try {
            $monErreur = "";
            $unServiceFrais = new ServiceFrais();
            $unFrais = $unServiceFrais->getById($id_frais);
            $titreVue = "Modification d'une fiche de frais";
            return view('vues/formFrais', compact('unFrais', 'titreVue', 'monErreur'));
        } catch (MonException $e) {
            $monErreur = $e->getMessage();
            return view('vues/error', compact('monErreur'));
        } catch (Exception $e) {
            $monErreur = $e->getMessage();
            return view('vues/error', compact('monErreur'));
        }
    }
}
