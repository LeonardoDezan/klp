<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FerramentaController extends Controller
{
    public function romaneios()
    {
        return view('ferramentas.romaneio');
    }

    public function importaestoque()
    {
        return view('ferramentas.importa-estoque');
    }
}
