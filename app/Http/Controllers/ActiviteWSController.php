<?php

namespace App\Http\Controllers;

use App\Models\ActiviteCompl;
use App\Models\Inviter;
use App\Models\Realiser;
use DateTime;
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
                'date_activite' => $activite_compl->date_activite->format('d-m-Y'),
                'lieu_activite' => $activite_compl->lieu_activite,
                'theme_activite' => $activite_compl->theme_activite,
                'motif_activite' => $activite_compl->motif_activite,
            ];
        });

        return response()->json($formattedactivite_compl);
    }

    function detail($id)
    {
        $activite_compl = ActiviteCompl::find($id);

        if (!$activite_compl) {
            return response()->json(['error' => 'Activité non trouvée'], 404);
        }

        $formattedActiviteCompl = [
            'id_activite_compl' => $activite_compl->id_activite_compl,
            'date_activite' => $activite_compl->date_activite->format('d-m-Y'),
            'lieu_activite' => $activite_compl->lieu_activite,
            'theme_activite' => $activite_compl->theme_activite,
            'motif_activite' => $activite_compl->motif_activite,
        ];

        return response()->json($formattedActiviteCompl);
    }


    function deleteActivite($id)
    {
        Realiser::where('id_activite_compl', $id)->delete();
        ActiviteCompl::destroy($id);
        return response()->json(['status' => "Activité supprimée"]);
    }

    public function activiteVisiteur($id_visiteur)
    {
        // Récupérer toutes les réalisations pour l'id_visiteur donné
        $realisations = Realiser::where('id_visiteur', $id_visiteur)->get();

        // Formatter les données
        $formattedActivites = $realisations->map(function ($realisation) {
            $activiteCompl = $realisation->activite_compl;
            return [
                'id_activite_compl' => $activiteCompl->id_activite_compl,
                'date_activite' => $activiteCompl->date_activite->format('d-m-Y'),
                'lieu_activite' => $activiteCompl->lieu_activite,
                'theme_activite' => $activiteCompl->theme_activite,
                'motif_activite' => $activiteCompl->motif_activite,
            ];
        });

        // Retourner les données formatées
        return response()->json($formattedActivites);
    }

    public function activitePraticien($id_praticien)
    {
        // Récupérer toutes les réalisations pour l'id_visiteur donné
        $realisations = Inviter::where('id_praticien', $id_praticien)->get();

        // Formatter les données
        $formattedActivites = $realisations->map(function ($realisation) {
            $activiteCompl = $realisation->activite_compl;
            return [
                'id_activite_compl' => $activiteCompl->id_activite_compl,
                'date_activite' => $activiteCompl->date_activite->format('d-m-Y'),
                'lieu_activite' => $activiteCompl->lieu_activite,
                'theme_activite' => $activiteCompl->theme_activite,
                'motif_activite' => $activiteCompl->motif_activite,
            ];
        });

        // Retourner les données formatées
        return response()->json($formattedActivites);
    }

    function ajoutActivite(Request $request)
    {
        $date_activite = DateTime::createFromFormat('d-m-Y', $request->date_activite)->format('Y-m-d');

        $lieu_activite = $request->lieu_activite;
        $theme_activite = $request->theme_activite;
        $motif_activite = $request->motif_activite;
        $id_visiteur = $request->id_visiteur;
        $type_visiteur = $request->type_visiteur;

        $activite = new ActiviteCompl();

        $activite->date_activite = $date_activite;
        $activite->lieu_activite = $lieu_activite;
        $activite->theme_activite = $theme_activite;
        $activite->motif_activite = $motif_activite;

        $activite->save();

        if($type_visiteur != "A") {
            $id_activite_compl = $activite->id_activite_compl;

            $realiser = new Realiser();

            $realiser->id_visiteur = $id_visiteur;
            $realiser->id_activite_compl = $id_activite_compl;
            $realiser->montant_ac = null;

            $realiser->save();
        }

        return response()->json(['status' => "Activité ajoutée", 'data' => $activite]);
    }

    function updateActivite(Request $request)
    {
        $id_activite = $request->id_activite_compl;

        $activite = ActiviteCompl::find($id_activite);

        $activite->date_activite = DateTime::createFromFormat('d-m-Y', $request->date_activite)->format('Y-m-d');
        $activite->lieu_activite = $request->lieu_activite;
        $activite->theme_activite = $request->theme_activite;
        $activite->motif_activite = $request->motif_activite;

        $activite->save();

        return response()->json(['status' => "Activité modifié", 'data' => $activite]);
    }
}
