<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('manutencoes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('veiculo_id')
                ->constrained('veiculos')
                ->cascadeOnDelete();

            // Data do serviço/compra
            $table->date('data');

            
            $table->enum('categoria', ['PECAS', 'SERVICO_EXTERNO', 'SERVICO_INTERNO']);

            // Texto livre do que foi feito
            $table->text('descricao');

            // Opcional
            $table->string('fornecedor')->nullable();
            $table->string('local')->nullable();

            $table->unsignedInteger('km')->nullable();

            $table->decimal('valor_total', 10, 2)->default(0);

            $table->string('tipo_documento')->nullable();
            $table->string('numero_documento')->nullable();

            $table->text('observacao')->nullable();

            $table->timestamps();
            $table->softDeletes(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('manutencoes');
    }
};