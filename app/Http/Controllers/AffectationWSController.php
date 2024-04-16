<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\Travailler;
use App\Models\Visiteur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\error;

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

    public function affectationUnique($id_travail)
    {
        try {
            // Récupérer l'affectation unique en fonction de l'id_visiteur
            $travail = Travailler::where('id_travail', $id_travail)->first();

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

    function ajoutAffectation(Request $request)
    {
        $id_visiteur = $request->id_visiteur;
        $jjmmaa = $request->jjmmaa;
        $id_region = $request->id_region;
        $role_visiteur = $request->role_visiteur;

        $travailler = new Travailler();

        $travailler->id_visiteur = $id_visiteur;
        $travailler->jjmmaa = $jjmmaa;
        $travailler->id_region = $id_region;
        $travailler->role_visiteur = $role_visiteur;

        $travailler->save();

        return response()->json(['status' => "Affectation ajouté", 'data' => $travailler]);
    }

    public function updateAffectation(Request $request)
    {
        try {
            // Récupérer les données de la requête
            $idAffectation = $request->id_travail;
            $id_visiteur = $request->id_visiteur;
            $jjmmaa = $request->jjmmaa;
            $id_region = $request->id_region;
            $role_visiteur = $request->role_visiteur;

            // Rechercher l'affectation à mettre à jour
            $travail = Travailler::where(['id_travail' => $idAffectation])->first();

            // Vérifier si l'affectation existe
            if (!$travail) {
                return response()->json(['error' => 'Affectation non trouvée'], 404);
            }

            $travail->update([
                'id_visiteur' => $id_visiteur,
                'jjmmaa' => $jjmmaa,
                'id_region' => $id_region,
                'role_visiteur' => $role_visiteur
            ]);

            return response()->json(['status' => "Affectation modifiée", 'data' => $travail]);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse JSON avec un message d'erreur
            return response()->json(['error' => 'Une erreur est survenue lors de la mise à jour de l\'affectation'], 500);
        }
    }

    public function deleteAffectation($id)
    {
        try {
            // Supprimer l'affectation en utilisant la colonne id_travail
            Travailler::where('id_travail', $id)->delete();

            return response()->json(['status' => "Affectation supprimée"]);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse JSON avec un message d'erreur
            return response()->json(['error' => 'Une erreur est survenue lors de la suppression de l\'affectation'], 500);
        }
    }
}
