<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Manutencao extends Model
{
    use SoftDeletes;

    protected $table = 'manutencoes';

    protected $fillable = [
        'veiculo_id',
        'data',
        'categoria',
        'descricao',
        'fornecedor',
        'local',
        'km',
        'valor_total',
        'tipo_documento',
        'numero_documento',
        'observacao',
    ];

    protected $casts = [
        'data' => 'date',
        'km' => 'integer',
        'valor_total' => 'decimal:2',
    ];

    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class);
    }

    public static function categorias(): array
    {
        return [
            'PECAS' => 'Peças',
            'SERVICO_EXTERNO' => 'Serviço Externo',
            'SERVICO_INTERNO' => 'Serviço Interno',
        ];
    }
}
