<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
        Schema::create('motoristas', function (Blueprint $table) {
            $table->id();

            $table->string('nome_completo');
            $table->string('cpf', 11)->unique();
            $table->string('rg', 20)->nullable();
            $table->string('telefone', 20)->nullable();
            $table->string('telefone_referencia', 20)->nullable();
            $table->string('nome_referencia', 120)->nullable();

            $table->string('cidade_nascimento', 120)->nullable();
            $table->char('uf_nascimento', 2)->nullable();

            $table->date('data_validade_cnh')->nullable();
            $table->date('data_nascimento')->nullable();

            $table->string('chave_pix', 140)->nullable();

            $table->enum('vinculo', ['funcionario', 'agregado', 'terceiro'])->index();

            $table->date('data_admissao')->nullable();
            $table->decimal('salario', 10, 2)->nullable();

            $table->boolean('ativo')->default(true)->index();

            $table->timestamps();

            $table->index(['nome_completo']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('motoristas');
    }
};
