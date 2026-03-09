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
        Schema::table('curso_formador', function (Blueprint $table) {
            // Remover as constraints anteriores
            $table->dropForeign(['curso_id']);
            $table->dropForeign(['formador_id']);
        });
        
        // Adicionar novas constraints com restrict (impede deleção)
        Schema::table('curso_formador', function (Blueprint $table) {
            $table->foreign('curso_id')
                ->references('id')
                ->on('cursos')
                ->onDelete('restrict');
            
            $table->foreign('formador_id')
                ->references('id')
                ->on('formadores')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('curso_formador', function (Blueprint $table) {
            // Reverter para cascade se necessário desfazer
            $table->dropForeign(['curso_id']);
            $table->dropForeign(['formador_id']);
        });
        
        Schema::table('curso_formador', function (Blueprint $table) {
            $table->foreign('curso_id')
                ->references('id')
                ->on('cursos')
                ->onDelete('cascade');
            
            $table->foreign('formador_id')
                ->references('id')
                ->on('formadores')
                ->onDelete('cascade');
        });
    }
};
