<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Despesa extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'descricao',
        'valor_unidade',
        'quantidade',
        'valor_total',
        'valor_pago',
        'pago',
        'categoria_despesa_id',
        'evento_id',
    ];

    protected $casts = [
        'valor_unidade' => 'float',
        'valor_total' => 'float',
        'valor_pago' => 'float',
        'pago' => 'boolean',
    ];

    public function categoriaDespesa(): BelongsTo
    {
        return $this->belongsTo(CategoriaDespesa::class);
    }
}
