<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        return view('clientes.index');
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function importarXml()
    {
        return view('clientes.importar-xml');
    }

    public function edit($id)
    {
        return view('clientes.create', ['clienteId' => $id]);
    }
}
