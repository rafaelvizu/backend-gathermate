<?php

namespace App\Models;

use App\Http\Controllers\V1\CategoriaDespesaController;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoriaEvento extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'nome',
        'descricao',
    ];

    public function eventos(): HasMany
    {
        return $this->hasMany(Evento::class);
    }
}
