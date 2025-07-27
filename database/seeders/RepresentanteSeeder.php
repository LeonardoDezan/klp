<?php

namespace Database\Seeders;

use App\Models\Representante;
use App\Models\RepresentanteContato;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RepresentanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Representante::factory()
            ->count(30)
            ->create()
            ->each(function ($representante) {
                RepresentanteContato::factory()
                    ->count(rand(1, 3))
                    ->create([
                        'representante_id' => $representante->id
                    ]);
            });

    }
}
