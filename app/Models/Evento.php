<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'nome',
        'descricao',
        'data_inicio',
        'data_fim',
        'online',
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
        'online' => 'boolean',
    ];
}
