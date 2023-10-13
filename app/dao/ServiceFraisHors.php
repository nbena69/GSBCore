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
}
