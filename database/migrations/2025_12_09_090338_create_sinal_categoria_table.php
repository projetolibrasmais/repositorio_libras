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
        Schema::create('sinal_categoria', function (Blueprint $table) {
            $table->foreignId('sinal_id')->constrained('sinais');
            $table->foreignId('categoria_id')->constrained('categorias');
            $table->primary(['sinal_id', 'categoria_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sinal_categoria');
    }
};
