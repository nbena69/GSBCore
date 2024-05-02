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

    public function deleteActivite($id_activite)
    {
        try {
            DB::table('activite_compl')->where('id_activite_compl', '=', $id_activite)->delete();
        } catch (QueryException $e) {
            throw new MonException($e->getMessage(), 5);
        }
    }
}
