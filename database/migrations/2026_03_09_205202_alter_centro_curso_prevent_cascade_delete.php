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
        Schema::table('centro_curso', function (Blueprint $table) {
            // Remover a constraint anterior (cascade delete)
            $table->dropForeign(['centro_id']);
        });
        
        // Adicionar nova constraint com restrict (impede deleção)
        Schema::table('centro_curso', function (Blueprint $table) {
            $table->foreign('centro_id')
                ->references('id')
                ->on('centros')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('centro_curso', function (Blueprint $table) {
            // Reverter para cascade se necessário desfazer
            $table->dropForeign(['centro_id']);
        });
        
        Schema::table('centro_curso', function (Blueprint $table) {
            $table->foreign('centro_id')
                ->references('id')
                ->on('centros')
                ->onDelete('cascade');
        });
    }
};
