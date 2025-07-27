<?php

namespace App\Http\Controllers;

use App\Models\Representante;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RepresentanteController extends Controller
{

    public function __construct(Representante $representante){
        $this->representante = $representante;
    }

    protected Representante $representante;


    public function index(): View{
        return view('representantes.index');
    }

    public function create(){
        return view('representantes.create');
    }

    public function edit($id)
    {
        return view('representantes.create', ['id' => $id]);
    }

}
