<?php

namespace App\Models;

use App\Http\Controllers\V1\CategoriaDespesaController;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'categoria_evento_id',
    ];

    protected $with = ['categoriaEvento'];

    protected $casts = [
        'data_inicio' => 'datetime',
        'data_fim' => 'datetime',
    ];

    public function inscricoes(): HasMany
    {
        return $this->hasMany(Inscricao::class);
    }

    public function categoriaEvento(): BelongsTo
    {
        return $this->belongsTo(CategoriaEvento::class, 'categoria_evento_id');
    }

}
