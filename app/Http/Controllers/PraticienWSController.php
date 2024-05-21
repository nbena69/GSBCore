<?php

namespace App\Http\Controllers;

use App\Models\Praticien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PraticienWSController extends Controller
{
    function praticienVille($ville_praticien)
    {
        return response()->json(Praticien::where('ville_praticien', $ville_praticien)->select('id_praticien', 'nom_praticien', 'prenom_praticien')->get());
    }
}
