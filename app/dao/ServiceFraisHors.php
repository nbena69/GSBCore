<?php

namespace App\dao;

use App\Exceptions\MonException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use App\Exceptions;
use App\metier\FraisHors;
use Illuminate\Support\Facades\Session;

class ServiceFraisHors
{
    public function getFraisHorsForfait($id_frais)
    {
        try {
            $lesFrais = DB::table('fraishorsforfait')
                ->select()
                ->where('id_frais', '=', $id_frais)
                ->get();
            return $lesFrais;
        } catch (QueryException $e) {
            throw new MonException($e->getMessage(), 5);
        }
    }
    public function getMontantTotalFraisHorsForfait($id_frais)
    {
        try {
            $montantTotal = DB::table('fraishorsforfait')
                ->where('id_frais', '=', $id_frais)
                ->sum('montant_fraishorsforfait');
            return $montantTotal;
        } catch (QueryException $e) {
            throw new MonException($e->getMessage(), 5);
        }
    }


    public function updateFraisHorsForfait($id_fraishorsforfait, $date_fraishorsforfait, $montant_fraishorsforfait, $lib_fraishorsforfait)
    {
        try {
            $dateJour = date("Y-m-d");
            DB::table('frais')
                ->where('id_fraishorsforfait', '=', $id_fraishorsforfait)
                ->update([
                    'date_fraishorsforfait' => $date_fraishorsforfait,
                    'montant_fraishorsforfait' => $montant_fraishorsforfait,
                    'lib_fraishorsforfait' => $lib_fraishorsforfait]);
        } catch (QueryException $e) {
            throw new MonException($e->getMessage(), 5);
        }
    }


    public function getByIdFraisHorsForfait($id_fraisHorsForfait){
        try {
            $fraisById = DB::table('fraishorsforfait')
                ->select()
                ->where('id_fraisHorsForfait', '=', $id_fraisHorsForfait)
                ->first();

        } catch (QueryException $e) {
            throw new MonException($e->getMessage(), 5);
        }
        return $fraisById;
    }


    public function insertFraisHorsForfait($id_frais, $date_fraishorsforfait, $montant_fraishorsforfait, $lib_fraishorsforfait)
    {
        try {
            $dateJour = date("Y-m-d");
            DB::table('fraishorsforfait')
                ->insert([
                    'id_frais' => $id_frais,
                    'date_fraishorsforfait' => $date_fraishorsforfait,
                    'montant_fraishorsforfait' => $montant_fraishorsforfait,
                    'lib_fraishorsforfait' => $lib_fraishorsforfait]);
        } catch (QueryException $e) {
            throw new MonException($e->getMessage(), 5);

        }
    }


    public function deleteFraisHors($id_fraisHors)
    {
        try {
            DB::table('fraishorsforfait')->where('id_fraishorsforfait', '=', $id_fraisHors)->delete();
        } catch (QueryException $e) {
            throw new MonException($e->getMessage(), 5);
        }
    }
}
