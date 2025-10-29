<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('motorista_seguros', function (Blueprint $table) {
            $table->id();

            $table->foreignId('motorista_id')
                ->constrained('motoristas')
                ->cascadeOnDelete();

            $table->date('validade_em');
            $table->string('gerenciadora_risco', 150);
            $table->timestamps();


            $table->index(['motorista_id', 'validade_em']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('motorista_seguros');
    }
};
