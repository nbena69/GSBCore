<?php

namespace App\Http\Controllers;

use App\Models\Frais;
use App\Models\Fraishorsforfait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FraisHorsForfaitWSController extends Controller
{
    function liste()
    {
        $fraishorsforfaits = Fraishorsforfait::all();

        $formattedFraishorsforfaits = $fraishorsforfaits->map(function ($fraishorsforfait) {
            return [
                'id_frais' => $fraishorsforfait->id_frais,
                'date_fraishorsforfait' => $fraishorsforfait->date_fraishorsforfait->format('d-m-Y'),
                'montant_fraishorsforfait' => $fraishorsforfait->montant_fraishorsforfait,
                'lib_fraishorsforfait' => $fraishorsforfait->lib_fraishorsforfait,
            ];
        });

        return response()->json($formattedFraishorsforfaits);
    }

    function detail($id)
    {
        $fraishorsforfait = Fraishorsforfait::find($id);

        if($fraishorsforfait) {
            $date_formatee = date('d-m-Y', strtotime($fraishorsforfait->date_fraishorsforfait));

            return response()->json([
                'id_frais' => $fraishorsforfait->id_frais,
                'id_fraishorsforfait' => $fraishorsforfait->id_fraishorsforfait,
                'date_fraishorsforfait' => $date_formatee,
                'montant_fraishorsforfait' => $fraishorsforfait->montant_fraishorsforfait,
                'lib_fraishorsforfait' => $fraishorsforfait->lib_fraishorsforfait
            ]);
        } else {
            // Retourner une réponse indiquant que le frais hors forfait n'existe pas
            return response()->json(['message' => 'Frais hors forfait non trouvé.'], 404);
        }
    }

    function listeParFrais($id) {
        $fraisHorsForfait = Fraishorsforfait::where('id_frais', "=", $id)->get();

        $formattedFraishorsforfaits = $fraisHorsForfait->map(function ($fraishorsforfait) {
            return [
                'id_frais' => $fraishorsforfait->id_frais,
                'id_fraishorsforfait' => $fraishorsforfait->id_fraishorsforfait,
                'date_fraishorsforfait' => $fraishorsforfait->date_fraishorsforfait->format('d-m-Y'),
                'montant_fraishorsforfait' => $fraishorsforfait->montant_fraishorsforfait,
                'lib_fraishorsforfait' => $fraishorsforfait->lib_fraishorsforfait,
            ];
        });

        return response()->json($formattedFraishorsforfaits);
    }

    function ajoutFraisHorsForfait(Request $request)
    {
        $id_frais = $request->id_frais;
        $date_fraishorsforfait = $request->date_fraishorsforfait;
        $montant_fraishorsforfait = $request->montant_fraishorsforfait;
        $lib_fraishorsforfait = $request->lib_fraishorsforfait;

        $fraisHorsForfait = new Fraishorsforfait();

        $fraisHorsForfait->id_frais = $id_frais;
        $fraisHorsForfait->date_fraishorsforfait = $date_fraishorsforfait;
        $fraisHorsForfait->montant_fraishorsforfait = $montant_fraishorsforfait;
        $fraisHorsForfait->lib_fraishorsforfait = $lib_fraishorsforfait;

        $fraisHorsForfait->save();

        return response()->json(['status' => "Frais Hors Forfait ajouté", 'data' => $fraisHorsForfait]);
    }

    function updateFraisHorsForfait(Request $request)
    {
        $idFraisHorsForfait = $request->id;

        $fraisHorsForfait = Fraishorsforfait::find($idFraisHorsForfait);

        if (!$fraisHorsForfait) {
            return response()->json(['status' => "Frais Hors Forfait non trouvé", 'data' => null]);
        }

        $fraisHorsForfait->id_frais = $request->id_frais;
        $fraisHorsForfait->date_fraishorsforfait = $request->date_fraishorsforfait;
        $fraisHorsForfait->montant_fraishorsforfait = $request->montant_fraishorsforfait;
        $fraisHorsForfait->lib_fraishorsforfait = $request->lib_fraishorsforfait;

        $fraisHorsForfait->save();

        return response()->json(['status' => "Frais Hors Forfait modifié", 'data' => $fraisHorsForfait]);
    }

    function deleteFraisHorsForfait($id)
    {
        Fraishorsforfait::destroy($id);
        return response()->json(['status' => "Frais Hors Forfait supprimée"]);
    }
}
