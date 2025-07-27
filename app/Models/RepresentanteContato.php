<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Representante;

class RepresentanteContato extends Model
{
    /** @use HasFactory<\Database\Factories\RepresentanteContatoFactory> */
    use HasFactory;


    protected $fillable = ['representante_id', 'nome', 'email', 'telefone'];

    public function representante()
    {
        return $this->belongsTo(Representante::class);
    }

    public function FormataTelefone(){
        $telefone = preg_replace('/\D/', '', $this->telefone);

    }

}
