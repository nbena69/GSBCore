<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
/**
 * Class LigneFraisforfait
 *
 * @property int $id_frais
 * @property int $id_fraisforfait
 * @property int|null $quantite_ligne
 *
 * @property Frais $frai
 * @property Fraisforfait $fraisforfait
 *
 * @package App\Models
 */
class LigneFraisforfait extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'ligne_fraisforfait';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_frais' => 'int',
		'id_fraisforfait' => 'int',
		'quantite_ligne' => 'int'
	];

	protected $fillable = [
		'quantite_ligne'
	];

	public function frai()
	{
		return $this->belongsTo(Frais::class, 'id_frais');
	}

	public function fraisforfait()
	{
		return $this->belongsTo(Fraisforfait::class, 'id_fraisforfait');
	}
}
