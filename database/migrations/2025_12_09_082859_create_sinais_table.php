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
            $table->text('definicao')->nullable();
            $table->text('config_mao')->nullable();
            $table->text('ponto_articulacao')->nullable();
            $table->text('orientacao_palma_mao')->nullable();
            $table->text('movimento')->nullable();
            $table->text('expressao_nao_manual')->nullable();
            $table->text('contexto_utilizacao')->nullable();
            $table->enum('status', ["catalogado", "em_validacao", "publicado"])->default('em_validacao');

            $table->timestamps();
            $table->softDeletes();
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
