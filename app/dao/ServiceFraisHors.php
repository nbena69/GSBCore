<?php

namespace App\dao;

use App\metier\FraisHors;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use App\Exceptions\MonException;
use Illuminate\Support\Facades\Session;

class ServiceFraisHors {
    public function getByIds($id_fraisHors, $id_frais)
    {
        try {
            $frais = DB::table('fraishorsforfait')
                ->where('id_fraishorsforfait', $id_fraisHors)
                ->where('id_frais', $id_frais)
                ->first();
            return $frais;
        } catch (QueryException $e) {
            throw new MonException($e->getMessage(), 5);
        }
    }
    public function getById($id_frais)
    {
        try {
            $frais = DB::table('fraishorsforfait')
                ->where('id_frais', $id_frais)
                ->first();
            return $frais;
        } catch (QueryException $e) {
            throw new MonException($e->getMessage(), 5);
        }
    }

    public function getFraisHors($id_frais)
    {
        try {
            $lesFraisHors = Db::table('fraishorsforfait')
                ->Select()
                ->where('fraishorsforfait.id_frais', '=', $id_frais)
                ->get();
            return $lesFraisHors;
        } catch (QueryException $e) {
            throw new MonException($e->getMessage(), 5);
        }
    }

    public function insertFraisHors($id_frais, $libelle, $date, $montant)
    {
        try {
            DB::table('frais')->insert(
                ['anneemois' => $anneemois,
                    'nbjustificatifs' => $nbjustificatifs,
                    'id_etat' => 2,
                    'id_visiteur' => $id_visiteur,
                    'montantvalide' => 0]
            );
        } catch (QueryException $e) {
            throw new MonException($e->getMessage(), 5);
        }
    }
    public function calculerMontantTotalFraisHorsForfait($fraisHorsForfait)
    {
        $montantTotal = 0;

        foreach ($fraisHorsForfait as $frais) {
            $montantTotal += $frais->montant;
        }

        return $montantTotal;
    }

}
