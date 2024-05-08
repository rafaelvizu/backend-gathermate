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
        return [
            //
            'descricao' => $this->faker->text,
            'valor_unidade' => $valor_unidade = $this->faker->randomFloat(2, 1, 1000),
            'quantidade' => $quantidade = $this->faker->randomDigitNotNull,
            'valor_total' => $valor_unidade * $quantidade,
            'valor_pago' => $valor_pago = $this->faker->randomFloat(2, 1, $valor_unidade * $quantidade),
            'categoria_despesa_id' => CategoriaDespesa::all()->random()->id,
            'evento_id' => Evento::all()->random()->id,
            'pago' => $valor_pago == $valor_unidade * $quantidade,
        ];
    }
}
