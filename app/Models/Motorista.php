<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Motorista extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome_completo',
        'cpf',
        'rg',
        'telefone',
        'telefone_referencia',
        'nome_referencia',
        'cidade_nascimento',
        'uf_nascimento',
        'data_validade_cnh',
        'data_nascimento',
        'chave_pix',
        'vinculo',
        'data_admissao',
        'salario',
        'ativo',
    ];

    protected $casts = [
        'data_validade_cnh' => 'date',
        'data_nascimento'   => 'date',
        'data_admissao'     => 'date',
        'salario'           => 'decimal:2',
        'ativo'             => 'boolean',
    ];

    /** Relacionamentos **/
    public function seguros()
    {
        return $this->hasMany(MotoristaSeguro::class);
    }

    public function documentos()
    {
        return $this->hasMany(MotoristaDocumento::class);
    }

    // Atalhos úteis (cada tipo é único por motorista)
    public function cnh()
    {
        return $this->hasOne(MotoristaDocumento::class)->where('tipo', 'cnh');
    }

    public function rgDoc()
    {
        return $this->hasOne(MotoristaDocumento::class)->where('tipo', 'rg');
    }

    public function comprovanteEndereco()
    {
        return $this->hasOne(MotoristaDocumento::class)->where('tipo', 'comprovante_endereco');
    }

    /** Escopos práticos **/
    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    public function scopePorVinculo($query, string $vinculo)
    {
        return $query->where('vinculo', $vinculo);
    }

    public function scopeBusca($query, ?string $termo)
    {
        if (!$termo) return $query;
        $t = trim($termo);
        return $query->where(function ($q) use ($t) {
            $q->where('nome_completo', 'like', "%{$t}%")
                ->orWhere('cpf', 'like', "%{$t}%")
                ->orWhere('rg', 'like', "%{$t}%")
                ->orWhere('telefone', 'like', "%{$t}%");
        });
    }

    /** Sanitizadores simples (garantem padrão no banco) **/
    public function setCpfAttribute($value)
    {
        $this->attributes['cpf'] = preg_replace('/\D/', '', (string) $value) ?: null;
    }

    public function setTelefoneAttribute($value)
    {
        $this->attributes['telefone'] = $value ? preg_replace('/\D/', '', (string) $value) : null;
    }

    public function setTelefoneReferenciaAttribute($value)
    {
        $this->attributes['telefone_referencia'] = $value ? preg_replace('/\D/', '', (string) $value) : null;
    }

    public function setUfNascimentoAttribute($value)
    {
        $this->attributes['uf_nascimento'] = $value ? mb_strtoupper((string) $value) : null;
    }
}
