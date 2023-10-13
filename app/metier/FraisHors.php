<?php

namespace App\metier;

use App\Exceptions\MonException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\QueryException;

class FraisHors extends model
{
    protected $table = 'fraishorsforfait';
    public $timestamps = false;
    public $id_fraisHors;
    protected $fillable = [
        'id_fraishorsforfait',
        'id_frais',
        'date_fraishorsforfait',
        'montant_fraishorsforfait',
        'lib_fraishorsforfait',
    ];

    public function __construct()
    {
        $this->id_fraisHors = 0;
    }


}
