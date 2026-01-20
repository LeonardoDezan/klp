<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('veiculos', function (Blueprint $table) {
            $table->id();

            $table->string('placa', 10)->unique();
            $table->string('renavam', 20)->nullable();

            // Proprietário (quem é o dono)
            $table->string('proprietario_nome', 150);
            $table->string('proprietario_documento', 20)->nullable();

            // Vínculo com a empresa
            $table->enum('vinculo', ['proprio', 'agregado', 'terceiro']);

            // Dados do veículo
            $table->string('chassi', 30)->nullable();
            $table->string('tipo', 50);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('veiculos');
    }
};