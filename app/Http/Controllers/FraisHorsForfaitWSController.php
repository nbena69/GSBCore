<?php

namespace App\Http\Controllers;

use App\metier\FraisHors;
use App\Models\Frais;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FraisHorsForfaitWSController extends Controller
{
    function liste()
    {
        return response()->json(FraisHors::all());
    }

    function detail($id)
    {
        return response()->json(FraisHors::find($id));
    }

    function listeParFrais($id) {
        $fraisHorsForfait = FraisHors::where('id_frais', $id)->get();

        return response()->json($fraisHorsForfait);
    }

    function ajoutFraisHorsForfait(Request $request)
    {
        $id_frais = $request->id_frais;
        $date_fraishorsforfait = $request->date_fraishorsforfait;
        $montant_fraishorsforfait = $request->montant_fraishorsforfait;
        $lib_fraishorsforfait = $request->lib_fraishorsforfait;

        $fraisHorsForfait = new FraisHors();

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

        $fraisHorsForfait = FraisHors::find($idFraisHorsForfait);

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
        FraisHors::destroy($id);
        return response()->json(['status' => "Frais Hors Forfait supprimée"]);
    }
}
