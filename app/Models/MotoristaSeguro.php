<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MotoristaSeguro extends Model
{
    use HasFactory;

    protected $fillable = [
        'motorista_id',
        'validade_em',
        'gerenciadora_risco',
    ];

    protected $casts = [
        'validade_em' => 'date',
    ];

    public function motorista()
    {
        return $this->belongsTo(Motorista::class);
    }

    /** Escopos úteis **/
    public function scopeDoMotorista($query, int $motoristaId)
    {
        return $query->where('motorista_id', $motoristaId);
    }

    public function scopeProximos($query)
    {
        return $query->whereDate('validade_em', '>=', now()->toDateString())
            ->orderBy('validade_em', 'asc');
    }

    public function scopeVencidos($query)
    {
        return $query->whereDate('validade_em', '<', now()->toDateString())
            ->orderBy('validade_em', 'desc');
    }
}
