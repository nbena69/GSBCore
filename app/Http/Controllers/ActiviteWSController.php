<?php

namespace App\Http\Controllers;

use App\Models\ActiviteCompl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActiviteWSController extends Controller
{
    function liste()
    {
        return response()->json(ActiviteCompl::all());
    }

    function detail($id)
    {
        return response()->json(ActiviteCompl::find($id));
    }

    function deleteActivite($id)
    {
        ActiviteCompl::destroy($id);
        return response()->json(['status' => "Activité supprimée"]);
    }
}
