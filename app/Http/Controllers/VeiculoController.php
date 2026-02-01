<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Veiculo;

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

    public function show(Veiculo $veiculo)
    {
        $veiculo->load([
            'manutencoes' => fn ($q) => $q->orderByDesc('data')->orderByDesc('id'),
        ]);

        return view('frota.veiculos.show', compact('veiculo'));
    }
}
