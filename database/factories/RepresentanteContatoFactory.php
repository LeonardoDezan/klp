<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Representante;
use Faker\Generator as Faker;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RepresentanteContato>
 */
class RepresentanteContatoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome'             => $this->faker->name(),
            'email'            => $this->faker->safeEmail(),
            'telefone'         => $this->faker->numerify('###########'),
            'representante_id' => Representante::factory(),
        ];
    }
}
