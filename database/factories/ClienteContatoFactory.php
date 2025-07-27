<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClienteContato>
 */
class ClienteContatoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => $this->faker->name(),
            'cargo' => $this->faker->jobTitle(),
            'telefone' => $this->faker->phoneNumber(),
            'email' => $this->faker->safeEmail(),
        ];
    }
}
