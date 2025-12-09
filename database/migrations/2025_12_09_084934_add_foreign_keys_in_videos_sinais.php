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
            $table->foreignId('sinal_id')->constrained('sinais');
        });

        Schema::table('sinais', function (Blueprint $table) {
            $table->foreignId('video_principal_id')->constrained('videos');
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

        Schema::table('sinais', function (Blueprint $table) {
            $table->dropForeign(['video_principal_id']);
            $table->dropColumn('video_principal_id');
        });
    }
};
