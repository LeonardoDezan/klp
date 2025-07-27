<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FerramentaController extends Controller
{
    public function romaneios()
    {
        return view('ferramentas.romaneio');
    }
}
