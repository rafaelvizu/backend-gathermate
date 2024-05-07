<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Evento extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'nome',
        'descricao',
        'data_inicio',
        'data_fim',
        'modalidade',
        'endereco',
        'cidade',
        'cep',
        'estado',
        'link',
        'imagem',
    ];

    protected $casts = [
        'data_inicio' => 'datetime',
        'data_fim' => 'datetime',
    ];

    public function inscricoes(): HasMany
    {
        return $this->hasMany(Inscricao::class);
    }

}
