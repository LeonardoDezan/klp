<?php
namespace Database\Factories;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClienteFactory extends Factory
{
    protected $model = Cliente::class;

    public function definition(): array
    {
//        return [
//            'razao_social' => $this->faker->company(),
//            'nome_fantasia' => $this->faker->companySuffix(),
//            'documento' => $this->faker->numberBetween(10000000000000, 99999999999999),
//            'endereco' => $this->faker->streetAddress(),
//            'bairro' => $this->faker->word(),
//            'cidade' => $this->faker->city(),
//            'horario_funcionamento' => [
//                'segunda_sexta' => [
//                    'inicio' => '08:00',
//                    'fim' => '12:00',
//                    'almoco_inicio' => '13:00',
//                    'almoco_fim' => '17:00',
//                ],
//                'sabado' => [
//                    'ativo' => rand(0, 1) === 1,
//                    'inicio' => '08:00',
//                    'fim' => '12:00',
//                    'almoco_inicio' => '—',
//                    'almoco_fim' => '—',
//                ]
//            ],
//            'tipos_veiculos' => $this->faker->randomElement(['Truck', 'Van', 'Carreta']),
//            'agendamento' => $this->faker->randomElement(['Sim', 'Não']),
//            'informacoes_descarga' => $this->faker->sentence(),
//
//        ];
    }
}

