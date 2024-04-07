<?php

namespace App\Http\Controllers;

use App\Models\ActiviteCompl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActiviteWSController extends Controller
{
    function liste()
    {
        $activite_compl = ActiviteCompl::all();

        $formattedactivite_compl = $activite_compl->map(function ($activite_compl) {
            return [
                'id_activite_compl' => $activite_compl->id_activite_compl,
                'date_activite' => $activite_compl->date_activite->format('Y-m-d'),
                'lieu_activite' => $activite_compl->lieu_activite,
                'theme_activite' => $activite_compl->theme_activite,
                'motif_activite' => $activite_compl->motif_activite,
            ];
        });

        return response()->json($formattedactivite_compl);
    }

    function detail($id)
    {
        return response()->json(ActiviteCompl::find($id));
    }

    function deleteActivite($id)
    {
        ActiviteCompl::destroy($id);
        return response()->json(['status' => "Activité supprimée"]);
    }
}
