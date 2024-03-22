<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\Secteur;
use App\Models\Travailler;
use App\Models\Visiteur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        $id_laboratoire = $request->id_laboratoire;
        $id_secteur = $request->id_secteur;
        $nom_visiteur = $request->nom_visiteur;
        $prenom_visiteur = $request->prenom_visiteur;
        $adresse_visiteur = $request->adresse_visiteur;
        $cp_visiteur = $request->cp_visiteur;
        $ville_visiteur = $request->ville_visiteur;
        $date_embauche = $request->date_embauche;
        $login_visiteur = $request->login_visiteur;
        $pwd_visiteur = Hash::make($request->pwd_visiteur);
        $type_visiteur = $request->type_visiteur;

        $visiteur = new Visiteur();

        $visiteur->id_laboratoire = $id_laboratoire;
        $visiteur->id_secteur = $id_secteur;
        $visiteur->nom_visiteur = $nom_visiteur;
        $visiteur->prenom_visiteur = $prenom_visiteur;
        $visiteur->adresse_visiteur = $adresse_visiteur;
        $visiteur->cp_visiteur = $cp_visiteur;
        $visiteur->ville_visiteur = $ville_visiteur;
        $visiteur->date_embauche = $date_embauche;
        $visiteur->login_visiteur = $login_visiteur;
        $visiteur->pwd_visiteur = $pwd_visiteur;
        $visiteur->type_visiteur = $type_visiteur;

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
                return response()->json(['error' => 'The provided credentials are
                incorrect.'], 401);
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
        return response()->json(['error' => 'Request must be JSON.'], 415);
    }

    public function logout(Request $request)
    {
        $visiteur = $request->user();
        $visiteur->tokens()->delete();

        return response()->json([
            'message' => 'Succesfully logged out'
        ]);
    }

    function rechercheVisiteur(Request $request)
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

        return response()->json($resultats);
    }

    function rechercheAvancee(Request $request)
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

        return response()->json($resultats);
    }

    public function updatePartielle(Request $request, $idVisiteur)
    {
        $visiteur = Visiteur::find($idVisiteur);

        if (!$visiteur) {
            return response()->json(['error' => 'Visiteur non trouvé'], 404);
        }

        $travailler = Travailler::where('id_visiteur', $idVisiteur)->first();

        if (!$travailler) {
            return response()->json(['error' => 'Aucune information de travail trouvée pour ce visiteur'], 404);
        }

        $region = $travailler->region;

        $visiteur->region()->associate($region);
        $visiteur->save();

        return response()->json(['message' => 'Région mise à jour avec succès', 'data' => $visiteur]);
    }


    public function obtenirInfosVisiteur($idVisiteur)
    {
        $visiteur = Visiteur::with('secteur')->find($idVisiteur);

        if (!$visiteur) {
            return response()->json(['error' => 'Visiteur non trouvé'], 404);
        }

        $travailler = Travailler::where('id_visiteur', $idVisiteur)->first();

        if (!$travailler) {
            return response()->json(['error' => 'Aucune information sur la région trouvée pour ce visiteur'], 404);
        }

        $response = [
            'nom_visiteur' => $visiteur->nom_visiteur,
            'prenom_visiteur' => $visiteur->prenom_visiteur,
            'id_secteur' => $visiteur->id_secteur,
            'id_laboratoire' => $visiteur->id_laboratoire,
            'id_region' => $travailler->id_region,
        ];

        return response()->json($response);
    }
}
