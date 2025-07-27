<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteContato extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'nome',
        'cargo',
        'telefone',
        'email',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
