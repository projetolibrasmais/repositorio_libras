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
        Schema::create('sinais', function (Blueprint $table) {
            $table->id();
            $table->string('palavra_portugues');
            $table->string('slug')->unique();
            $table->text('definicao');
            $table->text('instrucao_execucao');
            $table->enum('status', ["Sinal Existente Catalogado", "Em Validacao", "Publicado"])->default('Em Validacao');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sinals');
    }
};
