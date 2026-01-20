<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VeiculoController extends Controller
{
        public function create()
    {
        return view('frota.veiculos.create');
    }

    public function index()
    {
        return view('frota.veiculos.index');
    }

    public function edit($id)
    {
        return view('frota.veiculos.edit', compact('id'));
    }
}
