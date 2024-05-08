<?php

namespace Database\Factories;

use App\Models\CategoriaDespesa;
use App\Models\Evento;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Despesa>
 */
class DespesaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $valor_unidade = $this->faker->randomFloat();
        $quantidade = $this->faker->randomNumber();
        return [
            //
            'descricao' => $this->faker->text,
            'valor_unidade' => $valor_unidade,
            'quantidade' => $quantidade,
            'valor_total' => $valor_unidade * $quantidade,
            'categoria_id' => CategoriaDespesa::all()->random()->id,
            'evento_id' => Evento::all()->random()->id,
        ];
    }
}
