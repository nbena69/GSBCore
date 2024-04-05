<?php

namespace App\Http\Controllers;

use App\Models\Travailler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkWSController extends Controller
{
    function liste()
    {
        return response()->json(Travailler::all());
    }

    public function deleteAffectation(Request $request, $id_visiteur)
    {
        $jjmmaa = $request->input('jjmmaa');
        $id_region = $request->input('id_region');

        try {
            Travailler::where('id_visiteur', $id_visiteur)
                ->where('jjmmaa', $jjmmaa)
                ->where('id_region', $id_region)
                ->delete();

            return response()->json(['status' => "Affectation supprimée"]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Une erreur est survenue lors de la suppression de l\'affectation'], 500);
        }
    }
}
