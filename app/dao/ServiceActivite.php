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
            return $formattedActivites;
        } catch (QueryException $e) {
            throw new MonException($e->getMessage(), 5);
        }
    }


    public function searchVisiteur($keyword)
    {
        try {
            // Recherche un visiteur par son nom ou son laboratoire
            $resultats = DB::table('visiteur')
                ->where('nom_visiteur', 'like', "%$keyword%")
                ->orWhere('id_laboratoire', 'like', "%$keyword%")
                ->get();

            return $resultats;
        } catch (QueryException $e) {
            throw new MonException($e->getMessage(), 5);
        }
    }
}
