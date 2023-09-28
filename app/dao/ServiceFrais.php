<?php

namespace App\dao;

use App\metier\Frais;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use App\Exceptions\MonException;
use Illuminate\Support\Facades\Session;

class ServiceFrais
{
    public function getFrais($id_visiteur)
    {
        try {
            $lesFrais = Db::table('frais')
                ->Select()
                ->where('frais.id_visiteur', '=', $id_visiteur)
                ->get();
            return $lesFrais;
        } catch (QueryException $e) {
            throw new MonException($e->getMessage(), 5);
        }
    }

    public function updateFrais($id_frais, $anneemois, $nbjustificatifs)
    {
        try {
            $dateJour = date("Y-m-d");
            DB::table('frais')
                ->where('id_frais', '=', $id_frais)
                ->update(['anneemois' => $anneemois, 'nbjustificatifs' => $nbjustificatifs, 'datemodification' => $dateJour]);
        } catch (QueryException $e) {
            throw new MonException($e->getMessage(), 5);
        }
    }

    public function getById($id_frais)
    {
        try {
            $frais = Frais::find($id_frais);

            if ($frais) {
                return $frais;
            } else {
                throw new MonException('Frais non trouvé.');
            }
        } catch (\Exception $e) {
            throw new MonException('Une erreur s\'est produite lors de la récupération des données de frais.');
        }
    }

}
