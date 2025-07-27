<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\ClienteContato;
use App\Models\Representante;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Garantir representantes no banco
        if (Representante::count() === 0) {
            Representante::factory()->count(10)->create();
        }

        $representantes = Representante::all();

        Cliente::factory()->count(30)->create()->each(function ($cliente) use ($representantes) {
            ClienteContato::factory()->count(rand(1, 3))->create([
                'cliente_id' => $cliente->id,
            ]);

            if ($representantes->count() > 0) {
                $ids = $representantes->random(min(2, $representantes->count()))->pluck('id')->toArray();
                $cliente->representantes()->attach($ids);

                // Debug opcional
//                dump("Cliente {$cliente->razao_social} → representantes: ", $ids);
            }
        });
    }
}
