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
                'date_fraishorsforfait' => $fraishorsforfait->date_fraishorsforfait->format('Y-m-d'),
                'montant_fraishorsforfait' => $fraishorsforfait->montant_fraishorsforfait,
                'lib_fraishorsforfait' => $fraishorsforfait->lib_fraishorsforfait,
            ];
        });

        return response()->json($formattedFraishorsforfaits);
    }

    function detail($id)
    {
        return response()->json(Fraishorsforfait::find($id));
    }

    function listeParFrais($id) {
        $fraisHorsForfait = Fraishorsforfait::where('id_frais', "=", $id)->get();

        return response()->json($fraisHorsForfait);
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
