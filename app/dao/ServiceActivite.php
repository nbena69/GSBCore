<?php

namespace App\dao;

use App\Exceptions\MonException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use App\Exceptions;
use Illuminate\Support\Facades\Session;

class ServiceActivite
{
    public function getActivite()
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
