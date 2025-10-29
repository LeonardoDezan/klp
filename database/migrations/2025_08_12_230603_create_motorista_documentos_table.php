<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('motorista_documentos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('motorista_id')
                ->constrained('motoristas')
                ->cascadeOnDelete();

            $table->enum('tipo', ['cnh', 'rg', 'comprovante_endereco']); // limite aos 3
            $table->string('arquivo_path');                      // ex: storage/app/public/...
            $table->string('arquivo_original')->nullable();      // nome original enviado
            $table->string('mime_type', 100)->nullable();        // image/jpeg, application/pdf
            $table->unsignedBigInteger('tamanho_bytes')->nullable();

            $table->timestamps();

            $table->unique(['motorista_id', 'tipo']);            // 1 arquivo por tipo
        });
    }

    public function down(): void {
        Schema::dropIfExists('motorista_documentos');
    }
};
