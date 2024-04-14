<?php
namespace App\Http\Controllers;

use App\Models\Etat;
use App\Models\Laboratoire;
use App\Models\Region;
use App\Models\Secteur;
use App\Models\Specialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShortWSController extends Controller {
    function listeEtats()
    {
        return response()->json(Etat::all());
    }

    function listeSpecialite()
    {
        return response()->json(Specialite::all());
    }

    function listeLaboratoire()
    {
        return response()->json(Laboratoire::all());
    }

    function listeSecteur()
    {
        return response()->json(Secteur::all());
    }

    function listeRegion()
    {
        return response()->json(Region::all());
    }

    function listeRegionSecteur()
    {
        return response()->json(Region::join('secteur', 'region.id_secteur', '=', 'secteur.id_secteur')
            ->select('region.id_region', 'secteur.id_secteur', 'secteur.lib_secteur', 'region.nom_region')
            ->get());
    }
}
