<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Despesa extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'descricao',
        'valor_unidade',
        'quantidade',
        'valor_total',
        'categoria_id',
        'evento_id'
    ];

    protected $casts = [
        'valor_unidade' => 'float',
        'quantidade' => 'int',
        'valor_total' => 'float'
    ];
}
