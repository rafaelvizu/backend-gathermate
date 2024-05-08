<?php

namespace Database\Factories;

use App\Models\CategoriaEvento;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Evento>
 */
class EventoFactory extends Factory
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
            'nome' => $this->faker->unique()->word, // $this->faker->unique()->word(
            'descricao' => $this->faker->text,
            'data_inicio' => $this->faker->dateTimeBetween('now', '+1 month'),
            'data_fim' => $this->faker->dateTimeBetween('+1 month', '+2 month'),
            'modalidade' => $this->faker->randomElement(['PRESENCIAL', 'ONLINE', 'HIBRIDO']),
            'endereco' => $this->faker->address,
            'cidade' => $this->faker->city,
            'cep' => '00000-000',
            'estado' => $this->faker->city,
            'link' => $this->faker->url,
            'imagem' => $this->faker->imageUrl(),
            'categoria_evento_id' => CategoriaEvento::all()->random()->id,
        ];
    }
}
