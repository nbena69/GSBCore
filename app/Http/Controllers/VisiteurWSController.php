<?php

namespace App\Http\Controllers;

use App\Models\Travailler;
use App\Models\Visiteur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class VisiteurWSController extends Controller
{
    function liste()
    {
        return response()->json(Visiteur::all());
    }

    function visiteurVille($ville_visiteur)
    {
        return response()->json(Visiteur::where('ville_visiteur', $ville_visiteur)->select('id_visiteur', 'nom_visiteur')->get());
    }

    function visiteurNom($nom_visiteur)
    {
        return response()->json(Visiteur::where('nom_visiteur', 'like', '%' . $nom_visiteur . '%')->select("*")->get());
    }

    function ajoutVisiteur(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_laboratoire' => 'required|integer',
            'id_secteur' => 'required|integer',
            'nom_visiteur' => 'required|string',
            'prenom_visiteur' => 'required|string',
            'adresse_visiteur' => 'required|string',
            'cp_visiteur' => 'required|string|max:5|min:5',
            'ville_visiteur' => 'required|string',
            'date_embauche' => 'nullable|date',
            'login_visiteur' => 'required|string|unique:visiteur',
            'pwd_visiteur' => [
                'required',
                'string',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
            ],
            'type_visiteur' => 'required|string|max:1',
        ], [
            'id_laboratoire.required' => 'Le champ laboratoire est requis.',
            'id_secteur.required' => 'Le champ secteur est requis.',
            'nom_visiteur.required' => 'Le champ nom est requis.',
            'prenom_visiteur.required' => 'Le champ prénom est requis.',
            'adresse_visiteur.required' => 'Le champ adresse est requis.',
            'cp_visiteur.required' => 'Le champ code postal est requis.',
            'cp_visiteur.max' => 'Le champ code postal doit compter :max chiffres.',
            'cp_visiteur.min' => 'Le champ code postal doit compter :min chiffres.',
            'ville_visiteur.required' => 'Le champ ville est requis.',
            'date_embauche.date' => 'Le champ date d\'embauche doit être une date valide.',
            'login_visiteur.required' => 'Le champ login est requis.',
            'login_visiteur.unique' => 'Ce login est déjà utilisé.',
            'pwd_visiteur.required' => 'Le champ mot de passe est requis.',
            'pwd_visiteur.regex' => 'Le mot de passe doit contenir au moins 8 caractères, comprenant au moins une lettre minuscule, une lettre majuscule, un chiffre et un caractère spécial.',
            'type_visiteur.required' => 'Le champ type de visiteur est requis.',
            'type_visiteur.max' => 'Le champ type de visiteur ne doit pas dépasser :max caractère.',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $visiteur = new Visiteur();

        $visiteur->id_laboratoire = $request->id_laboratoire;
        $visiteur->id_secteur = $request->id_secteur;
        $visiteur->nom_visiteur = $request->nom_visiteur;
        $visiteur->prenom_visiteur = $request->prenom_visiteur;
        $visiteur->adresse_visiteur = $request->adresse_visiteur;
        $visiteur->cp_visiteur = $request->cp_visiteur;
        $visiteur->ville_visiteur = $request->ville_visiteur;
        $visiteur->date_embauche = $request->date_embauche;
        $visiteur->login_visiteur = $request->login_visiteur;
        $visiteur->pwd_visiteur = Hash::make($request->pwd_visiteur);
        $visiteur->type_visiteur = $request->type_visiteur;

        $visiteur->save();

        return response()->json(['status' => "Visiteur ajouté", 'data' => $visiteur]);
    }

    function updateVisiteur(Request $request)
    {
        $idVisiteur = $request->id;

        $visiteur = Visiteur::find($idVisiteur);

        if (!$visiteur) {
            return response()->json(['status' => "Visiteur non trouvé", 'data' => null]);
        }

        $visiteur->id_laboratoire = $request->id_laboratoire;
        $visiteur->id_secteur = $request->id_secteur;
        $visiteur->nom_visiteur = $request->nom_visiteur;
        $visiteur->prenom_visiteur = $request->prenom_visiteur;
        $visiteur->adresse_visiteur = $request->adresse_visiteur;
        $visiteur->cp_visiteur = $request->cp_visiteur;
        $visiteur->ville_visiteur = $request->ville_visiteur;
        $visiteur->date_embauche = $request->date_embauche;
        $visiteur->login_visiteur = $request->login_visiteur;
        $visiteur->pwd_visiteur = $request->pwd_visiteur;
        $visiteur->type_visiteur = $request->type_visiteur;

        $visiteur->save();

        return response()->json(['status' => "Visiteur modifié", 'data' => $visiteur]);
    }

    function deleteVisiteur($id)
    {
        Visiteur::destroy($id);
        return response()->json(['status' => "Visiteur supprimée"]);
    }

    public function getConnexion(Request $request)
    {
        if ($request->login_visiteur != null) {
            $login_visiteur = $request->login_visiteur;
            $pwd_visiteur = $request->pwd_visiteur;

            $visiteur = Visiteur/*AuthVisiteur*/ ::where('login_visiteur', $login_visiteur)
                ->where('pwd_visiteur', $pwd_visiteur)
                ->first();

            if ($visiteur) {
                return response()->json(['status' => "Visiteur identifié", 'data' => $visiteur]);
            } else {
                return response()->json(['status' => "Authentification incorrects", 'data' => null], 401);
            }
        } else {
            return response()->json(['status' => "Paramètres manquants", 'data' => null], 400);
        }
    }

    public function updatePassword()
    {
        try {
            $visiteurs = Visiteur::all();

            foreach ($visiteurs as $visiteur) {
                $visiteur->pwd_visiteur = Hash::make($visiteur->pwd_visiteur);
                $visiteur->save();
            }

            return response()->json(['status' => "Mots de passe mis à jour avec succès", 'data' => $visiteurs]);
        } catch (\Exception $e) {
            return response()->json(['status' => "Erreur lors de la mise à jour des mots de passe", 'data' => null], 500);
        }
    }

    public function login(Request $request)
    {
        if ($request->isJson()) {
            $data = $request->json()->all();
            // Validation des données reçues, il faut un login et un password
            $request->validate([
                'login' => 'required',
                'password' => 'required',
            ]);
            // Correspondance pour la validation des données
            $credentials = ['login_visiteur' => $data['login'], 'password' =>
                $data['password']];
            // Auth valide que l'email et le password existe dans la table users
            if (!Auth::attempt($credentials)) {
                return response()->json(['error' => 'Les données fournis sont incorrect.'], 401);
            }
            // on récupère les infos du user
            $visiteur = $request->user();
            // Création et sauvegarde du token user
            $tokenResult2 = $visiteur->createToken('Personal Access Token');
            $token = $tokenResult2->plainTextToken;
            $visiteur->remember_token = $token;
            $visiteur->save();
            // On retourne un JSON pour Angular
            return response()->json([
                'visiteur' => [
                    'id_visiteur' => $visiteur->id_visiteur,
                    'nom_visiteur' => $visiteur->nom_visiteur,
                    'prenom_visiteur' => $visiteur->prenom_visiteur,
                    'type_visiteur' => $visiteur->type_visiteur,
                ],
                'access_token' => $token,
                'token_type' => 'bearer',
            ]);
        }
        // Gestion des erreurs si la requête n'est pas en JSON
        return response()->json(['error' => 'La requête n\'est pas en JSON.'], 415);
    }

    public function logout(Request $request)
    {
        $visiteur = $request->user();
        $visiteur->tokens()->delete();

        return response()->json([
            'message' => 'Succès de la deconnexion'
        ]);
    }

    function filtreAffectation(Request $request)
    {
        $nom = $request->query('nom');
        $idSecteur = $request->query('id_secteur');
        $idLaboratoire = $request->query('id_laboratoire');

        if (!$nom && !$idSecteur && !$idLaboratoire) {
            return response()->json(['error' => 'Au moins un paramètre est requis pour effectuer la recherche.'], 400);
        }

        $query = Visiteur::query();

        if ($nom) {
            $query->where('nom_visiteur', 'like', "%$nom%");
        }

        if ($idSecteur) {
            $query->where('id_secteur', $idSecteur);
        }

        if ($idLaboratoire) {
            $query->where('id_laboratoire', $idLaboratoire);
        }

        $resultats = $query->get();

        if ($resultats->isEmpty()) {
            return response()->json(['error' => 'Aucun visiteur trouvé.'], 404);
        }

        return response()->json($resultats);
    }

    function filtreAffectAvancee(Request $request)
    {
        $nom = $request->query('nom');

        if (!$nom) {
            return response()->json(['error' => 'Au moins un paramètre est requis pour effectuer la recherche.'], 400);
        }

        $query = Visiteur::query();

        $query->where('nom_visiteur', 'like', "%$nom%")
            ->orWhereHas('laboratoire', function ($query) use ($nom) {
                $query->where('nom_laboratoire', 'like', "%$nom%");
            })
            ->orWhereHas('secteur', function ($query) use ($nom) {
                $query->where('lib_secteur', 'like', "%$nom%");
            });

        $resultats = $query->get();

        if ($resultats->isEmpty()) {
            return response()->json(['error' => 'Aucun visiteur trouvé.'], 404);
        }

        return response()->json($resultats);
    }

    public function obtenirInfosAffectation($idVisiteur)
    {
        $visiteur = Visiteur::with('secteur')->find($idVisiteur);

        if (!$visiteur) {
            return response()->json(['error' => 'Visiteur non trouvé'], 404);
        }

        // Récupérer toutes les entrées travailler pour le visiteur donné
        $travaux = Travailler::where('id_visiteur', $idVisiteur)->get();

        // Créer un tableau pour stocker les informations sur chaque région avec leurs jjmmaa associés
        $regions = [];

        foreach ($travaux as $travail) {
            $region = $travail->region;

            // Créer une clé unique pour cette affectation basée sur l'id_region et jjmmaa
            $cleAffectation = $region->id_region . '_' . $travail->jjmmaa->format('Y-m-d');

            // Vérifier si l'affectation existe déjà dans le tableau
            if (!isset($regions[$cleAffectation])) {
                // Si l'affectation n'existe pas, ajouter les informations dans le tableau
                $regions[$cleAffectation] = [
                    'id_region' => $region->id_region,
                    'nom_region' => $region->nom_region,
                    'id_secteur' => $region->id_secteur,
                    'jjmmaa' => $travail->jjmmaa->format('Y-m-d'),
                ];
            }
        }

        // Convertir le tableau associatif en tableau indexé pour la réponse JSON
        $regions = array_values($regions);

        return response()->json([
            'id_visiteur' => $visiteur->id_visiteur,
            'nom_visiteur' => $visiteur->nom_visiteur,
            'prenom_visiteur' => $visiteur->prenom_visiteur,
            'id_laboratoire' => $visiteur->id_laboratoire,
            'regions' => $regions,
        ]);
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

    public function affectation(Request $request)
    {
        // Récupérer les données de la requête
        $id_visiteur = $request->id_visiteur;
        $jjmmaa = $request->jjmmaa;
        $id_region = $request->id_region;
        $role_visiteur = $request->role_visiteur;

        // Créer une nouvelle instance de Travailler
        $travailler = new Travailler();

        // Assigner les valeurs
        $travailler->id_visiteur = $id_visiteur;
        $travailler->jjmmaa = $jjmmaa;
        $travailler->id_region = $id_region;
        $travailler->role_visiteur = $role_visiteur;

        // Sauvegarder dans la base de données
        $travailler->save();

        // Retourner une réponse JSON
        return response()->json(['status' => 'Visiteur affectée', 'data' => $travailler]);
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
