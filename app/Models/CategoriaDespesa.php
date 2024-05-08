<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoriaDespesa extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'nome',
        'descricao',
    ];

    public function Despesas(): HasMany
    {
        return $this->hasMany(Despesa::class);
    }
}
