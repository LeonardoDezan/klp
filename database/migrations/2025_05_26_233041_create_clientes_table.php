<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('razao_social');
            $table->string('nome_fantasia')->nullable();
            $table->string('documento'); // CNPJ ou CPF
            $table->string('endereco')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cidade')->nullable();
            $table->string('uf', 2)->nullable();
            $table->string('tipos_veiculos')->nullable();
            $table->time('inicio_semana')->nullable();
            $table->time('parada_semana')->nullable();
            $table->time('retorno_semana')->nullable();
            $table->time('fim_semana')->nullable();
            $table->boolean('funciona_sabado')->default(false);
            $table->time('inicio_sabado')->nullable();
            $table->time('parada_sabado')->nullable();
            $table->time('retorno_sabado')->nullable();
            $table->time('fim_sabado')->nullable();
            $table->string('agendamento')->nullable();
            $table->text('informacoes_descarga')->nullable();
            $table->text('observacoes')->nullable();
            $table->string('localizacao')->nullable();
            $table->softDeletes();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
