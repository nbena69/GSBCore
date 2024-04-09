<?php

namespace App\Http\Controllers;

use App\Models\Travailler;
use App\Models\Visiteur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AffectationWSController extends Controller
{
    function liste()
    {
        return response()->json(Travailler::all());
    }

    public function affectationVisiteur($id_visiteur)
    {
        try {
            // Récupérer toutes les affectations du visiteur donné
            $travaux = Travailler::where('id_visiteur', $id_visiteur)->get();

            // Vérifier si des travaux ont été trouvés
            if ($travaux->isEmpty()) {
                return response()->json(['message' => 'Aucune affectation trouvée pour ce visiteur'], 404);
            }

            // Formater les données, notamment la date
            $travauxFormatted = $travaux->map(function ($travail) {
                return [
                    'id_travail' => $travail->id_travail,
                    'id_visiteur' => $travail->id_visiteur,
                    'jjmmaa' => $travail->jjmmaa->format('d-m-Y'),
                    'role_visiteur' => $travail->role_visiteur,
                    'id_region' => $travail->id_region,
                    'nom_region' => $travail->region->nom_region
                ];
            });

            // Retourner les affectations formatées
            return response()->json($travauxFormatted);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse JSON avec un message d'erreur
            return response()->json(['error' => 'Une erreur est survenue lors de la récupération des affectations'], 500);
        }
    }

    public function affectationUnique($id_visiteur)
    {
        try {
            // Récupérer l'affectation unique en fonction de l'id_visiteur
            $travail = Travailler::where('id_visiteur', $id_visiteur)->first();

            // Vérifier si l'affectation a été trouvée
            if (!$travail) {
                return response()->json(['message' => 'Aucune affectation trouvée pour cet identifiant de visiteur'], 404);
            }

            // Formater les données, notamment la date
            $travailFormatted = [
                'id_travail' => $travail->id_travail,
                'id_visiteur' => $travail->id_visiteur,
                'jjmmaa' => $travail->jjmmaa->format('d-m-Y'),
                'role_visiteur' => $travail->role_visiteur,
                'id_region' => $travail->id_region,
                'id_secteur' => $travail->region->id_secteur,
                'nom_region' => $travail->region->nom_region
            ];

            return response()->json($travailFormatted);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Une erreur est survenue lors de la récupération de l\'affectation'], 500);
        }
    }

    public function updateAffectation(Request $request, $idVisiteur)
    {
        $visiteur = Visiteur::find($idVisiteur);

        if (!$visiteur) {
            return response()->json(['error' => 'Visiteur non trouvé'], 404);
        }

        // Vérification des données requises
        $validator = Validator::make($request->all(), [
            'jjmmaa' => 'required|date',
            'ancienne_id_region' => 'required|integer',
            'id_region' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        // Récupération des données de la requête
        $ancienneIdRegion = $request->input('ancienne_id_region');
        $nouvelleIdRegion = $request->input('id_region');
        $jjmmaa = $request->input('jjmmaa');

        try {
            DB::beginTransaction();

            // Vérification si la région à mettre à jour est différente
            if ($ancienneIdRegion !== $nouvelleIdRegion) {
                // Mettre à jour la ligne correspondante dans la table travailler
                $affectedRows = Travailler::where('id_visiteur', $idVisiteur)
                    ->where('jjmmaa', $jjmmaa)
                    ->where('id_region', $ancienneIdRegion)
                    ->update(['id_region' => $nouvelleIdRegion]);

                // Vérification si aucune ligne n'a été affectée (pas de mise à jour)
                if ($affectedRows === 0) {
                    return response()->json(['error' => 'Aucune information de travail trouvée pour ce visiteur à cette date avec l\'ancienne région fournie'], 404);
                }
            }
            DB::commit();

            return response()->json(['message' => 'Région mise à jour avec succès']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Une erreur est survenue lors de la mise à jour des informations de travail'], 500);
        }
    }

    public function deleteAffectation(Request $request)
    {
        $idVisiteur = $request->input('id_visiteur');
        $jjmmaa = $request->input('jjmmaa');
        $idRegion = $request->input('id_region');

        try {
            // Supprimer l'entrée correspondante dans la table travailler
            Travailler::where('id_visiteur', $idVisiteur)
                ->where('jjmmaa', $jjmmaa)
                ->where('id_region', $idRegion)
                ->delete();

            // Retourner une réponse JSON indiquant que l'entrée a été supprimée avec succès
            return response()->json(['status' => 'Travailler supprimé avec succès']);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse JSON avec le message d'erreur
            return response()->json(['error' => 'Une erreur est survenue lors de la suppression du travailleur'], 500);
        }
    }
}
