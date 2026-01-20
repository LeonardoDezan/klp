<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Veiculo extends Model
{
    use HasFactory;

    protected $table = 'veiculos';

        protected $fillable = [
            'placa',
            'renavam',
            'proprietario_nome',
            'proprietario_documento',
            'vinculo',
            'chassi',
            'tipo',
        ];

    
}
