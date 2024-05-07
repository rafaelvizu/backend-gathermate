<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inscricao extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'evento_id',
        'nome',
        'email',
        'cpf',
    ];


    public function evento(): BelongsTo
    {
        return $this->belongsTo(Evento::class);
    }
}
