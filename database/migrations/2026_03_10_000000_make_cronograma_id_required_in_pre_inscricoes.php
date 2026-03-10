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
        Schema::table('pre_inscricoes', function (Blueprint $table) {
            // Remover a constraint anterior (SET NULL)
            $table->dropForeign(['cronograma_id']);
        });
        
        Schema::table('pre_inscricoes', function (Blueprint $table) {
            // Adicionar nova constraint com CASCADE
            $table->foreign('cronograma_id')
                ->references('id')
                ->on('cronogramas')
                ->onDelete('cascade');
            
            // Mudar cronograma_id de nullable para NOT NULL
            $table->foreignId('cronograma_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pre_inscricoes', function (Blueprint $table) {
            // Remover a constraint anterior (CASCADE)
            $table->dropForeign(['cronograma_id']);
        });
        
        Schema::table('pre_inscricoes', function (Blueprint $table) {
            // Restaurar constraint original (SET NULL)
            $table->foreign('cronograma_id')
                ->references('id')
                ->on('cronogramas')
                ->onDelete('set null');
            
            // Reverter para nullable
            $table->foreignId('cronograma_id')->nullable()->change();
        });
    }
};
