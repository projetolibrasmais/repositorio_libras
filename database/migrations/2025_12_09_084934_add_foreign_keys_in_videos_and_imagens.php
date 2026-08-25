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
        Schema::table('videos', function (Blueprint $table) {
            $table->unsignedBigInteger('sinal_id')->nullable();
            $table->foreign('sinal_id')->references('id')->on('sinais')->onDelete('cascade');
        });

        Schema::table('imagens', function (Blueprint $table) {
            $table->unsignedBigInteger('sinal_id')->nullable();
            $table->foreign('sinal_id')->references('id')->on('sinais')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->dropForeign(['sinal_id']);
            $table->dropColumn('sinal_id');
        });

        Schema::table('imagens', function (Blueprint $table) {
            $table->dropForeign(['sinal_id']);
            $table->dropColumn('sinal_id');
        });
    }
};
