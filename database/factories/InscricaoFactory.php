<?php

namespace Database\Factories;

use App\Models\Evento;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inscricao>
 */
class InscricaoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // evento de for
        return [
            'evento_id' => Evento::all()->random()->id,
            'nome' => $this->faker->word,
            'email' => $this->faker->unique()->safeEmail,
            'cpf' => '000.000.000-00'
        ];
    }
}
