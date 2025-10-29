<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MotoristaController extends Controller
{
    public function index()
    {
        return view('motoristas.index');
    }

    public function create()
    {
        return view('motoristas.create');
    }

    public function edit($id)
    {
        return view('motoristas.create', compact('id'));
    }

}
