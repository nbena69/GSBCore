<?php

namespace App\metier;

use App\Exceptions\MonException;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\QueryException;

class Frais extends model
{
    protected $table = 'frais';
    public $timestamps = false;
    private $id_frais;
    protected $fillable = [
        'id_frais',
        'id_etat',
        'anneemois',
        'id_visiteur',
        'nbjustificatifs',
        'datemodification',
        'montantvalide'
    ];

    public function __construct()
    {
        $this->id_frais = 0;
    }

    public function deleteFrais($id_frais)
    {
        try {
            DB::table('fraishorsforfait')->where('id_frais', '=', $id_frais)->delete();
            DB::table('frais')->where('id_frais', '=', $id_frais)->delete();
        } catch (QueryException $e) {
            throw new MonException($e->getMessage(), 5);
        }
    }
}
