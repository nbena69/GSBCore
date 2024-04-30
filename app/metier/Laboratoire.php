<?php

namespace App\metier;

use Illuminate\Database\Eloquent\Model;

class Laboratoire extends Model
{
    protected $table = 'laboratoire';
    protected $primaryKey = 'id_laboratoirePrimaire';
    public $timestamps = false; // Si vos tables n'ont pas de champs created_at et updated_at

    protected $fillable = [
        'nom_laboratoire',
        'chef_vente'
    ];

    // Si vous utilisez AUTO_INCREMENT pour l'ID, assurez-vous de le spécifier
    protected $guarded = ['id_laboratoirePrimaire'];
}

