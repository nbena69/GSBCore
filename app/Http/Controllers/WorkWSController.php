<?php

namespace App\Http\Controllers;

use App\Models\Travailler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkWSController extends Controller
{
    function liste()
    {
        return response()->json(Travailler::all());
    }
}
