<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RepresentanteContato;

class Representante extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'observacao',
    ];

    public function representante_contatos()
    {
        return $this->hasMany(RepresentanteContato::class);
    }

    public function Busca($query, $search)
    {
        return $query->when($search, fn($q) => $q->where('nome', 'like', "%{$search}%"));
    }

    public function clientes()
    {
        return $this->belongsToMany(Cliente::class);
    }


}
