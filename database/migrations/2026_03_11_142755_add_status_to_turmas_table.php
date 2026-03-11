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
        Schema::table('turmas', function (Blueprint $table) {
            // Adicionar campo status com enum
            $table->enum('status', ['planeada', 'inscricoes_abertas', 'em_andamento', 'concluida'])->default('planeada')->after('duracao_semanas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('turmas', function (Blueprint $table) {
            // Remover campo status
            $table->dropColumn('status');
        });
    }
};
