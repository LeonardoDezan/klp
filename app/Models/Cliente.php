<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'razao_social',
        'nome_fantasia',
        'documento',
        'endereco',
        'bairro',
        'cidade',
        'uf',
        'tipos_veiculos',
        'agendamento',
        'informacoes_descarga',
        'observacoes',
        'inicio_semana',
        'parada_semana',
        'retorno_semana',
        'fim_semana',
        'inicio_sabado',
        'parada_sabado',
        'retorno_sabado',
        'fim_sabado',
        'localizacao',
    ];

    protected $dates = ['deleted_at'];

    public function contatos()
    {
        return $this->hasMany(ClienteContato::class);
    }

    public function representantes()
    {
        return $this->belongsToMany(Representante::class);
    }
//    public function fotos()
//    {
//        return $this->hasMany(ClienteFoto::class);
//    }
}
