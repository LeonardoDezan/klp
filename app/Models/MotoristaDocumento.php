<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class MotoristaDocumento extends Model
{
    use HasFactory;

    public const TIPOS = ['cnh', 'rg', 'comprovante_endereco'];

    protected $fillable = [
        'motorista_id',
        'tipo',              // 'cnh' | 'rg' | 'comprovante_endereco'
        'arquivo_path',
        'arquivo_original',
        'mime_type',
        'tamanho_bytes',
    ];

    protected $casts = [
        'tamanho_bytes' => 'integer',
    ];

    protected $appends = ['url'];

    public function motorista()
    {
        return $this->belongsTo(Motorista::class);
    }

    public function getUrlAttribute(): ?string
    {
        return $this->arquivo_path ? Storage::url($this->arquivo_path) : null;
    }

    // Garantir tipos válidos (opcional, ajuda a evitar erro de digitação)
    public function setTipoAttribute($value)
    {
        $v = strtolower((string) $value);
        if (!in_array($v, self::TIPOS, true)) {
            throw new \InvalidArgumentException("Tipo de documento inválido: {$v}");
        }
        $this->attributes['tipo'] = $v;
    }
}
