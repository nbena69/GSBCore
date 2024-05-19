<?php

namespace App\dao;

use App\Exceptions\MonException;
use App\Models\Realiser;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use App\Exceptions;
use Illuminate\Support\Facades\Session;

class ServiceActivite
{
    public function getAllActivite()
    {
        try {
            $lesActivites = DB::table('activite_compl')
                ->select()
                ->get();
            return $lesActivites;
        } catch (QueryException $e) {
            throw new MonException($e->getMessage(), 5);
        }
    }

    public function getActivite($id_visiteur)
    {
        try {
            $activites = DB::table('realiser')
                ->join('activite_compl', 'realiser.id_activite_compl', '=', 'activite_compl.id_activite_compl')
                ->select('activite_compl.id_activite_compl', 'activite_compl.date_activite', 'activite_compl.lieu_activite', 'activite_compl.theme_activite', 'activite_compl.motif_activite')
                ->where('realiser.id_visiteur', "=", $id_visiteur)
                ->get();

            return $activites;
        } catch (QueryException $e) {
            throw new MonException($e->getMessage(), 5);
        }
    }

    public function getInviter($id_activite)
    {
        try {
            $inviter = DB::table('inviter')
                ->join('praticien', 'inviter.id_praticien', '=', 'praticien.id_praticien')
                ->select('praticien.nom_praticien', 'praticien.prenom_praticien', 'praticien.id_praticien')
                ->where('inviter.id_activite_compl', "=", $id_activite)
                ->get();

            // Retourner une liste des noms des praticiens
            return $inviter;
        } catch (QueryException $e) {
            throw new MonException($e->getMessage(), 5);
        }
    }

    public function updateActivite($id_activite, $date_activite, $lieu_activite, $theme_activite, $motif_activite)
    {
        try {
            DB::table('activite_compl')
                ->where('id_activite_compl', '=', $id_activite)
                ->update(['date_activite' => $date_activite,
                    'lieu_activite' => $lieu_activite,
                    'theme_activite' => $theme_activite,
                    'motif_activite' => $motif_activite
                ]);
        } catch (QueryException $e) {
            throw new MonException($e->getMessage(), 5);
        }
    }

    public function insertActivite($id_visiteur, $date_activite, $lieu_activite, $theme_activite, $motif_activite)
    {
        try {
            // Insertion dans la table activite_compl et récupération de l'ID auto-incrémenté
            $id_activite_compl = DB::table('activite_compl')
                ->insertGetId([
                    'date_activite' => $date_activite,
                    'lieu_activite' => $lieu_activite,
                    'theme_activite' => $theme_activite,
                    'motif_activite' => $motif_activite
                ]);

            // Insertion dans la table realiser en utilisant l'ID récupéré
            DB::table('realiser')
                ->insert([
                    'id_activite_compl' => $id_activite_compl,
                    'id_visiteur' => $id_visiteur,
                    'montant_ac' => 0.00
                ]);
        } catch (QueryException $e) {
            throw new MonException($e->getMessage(), 5);
        }
    }

    public function deleteActivite($id_activite, $id_visiteur)
    {
        try {
            DB::table('realiser')
                ->where('id_activite_compl', '=', $id_activite)
                ->where('id_visiteur', '=', $id_visiteur)
                ->delete();
        } catch (QueryException $e) {
            throw new MonException($e->getMessage(), 5);
        }
    }

    public function deleteInviter($id_praticien)
    {
        try {
            DB::table('inviter')
                ->where('id_praticien', '=', $id_praticien)
                ->delete();
        } catch (QueryException $e) {
            throw new MonException($e->getMessage(), 5);
        }
    }

    public function getById($id_activite)
    {
        try {
            $activiteById = DB::table('activite_compl')
                ->select()
                ->where('id_activite_compl', '=', $id_activite)
                ->first();

        } catch (QueryException $e) {
            throw new MonException($e->getMessage(), 5);
        }
        return $activiteById;
    }
}
