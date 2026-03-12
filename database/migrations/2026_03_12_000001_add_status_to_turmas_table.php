<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Adicionar coluna status à tabela turmas
     */
    public function up(): void
    {
        Schema::table('turmas', function (Blueprint $table) {
            if (!Schema::hasColumn('turmas', 'status')) {
                $table->enum('status', ['planeada', 'inscricoes_abertas', 'em_andamento', 'concluida'])
                    ->default('planeada')
                    ->after('periodo');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('turmas', function (Blueprint $table) {
            if (Schema::hasColumn('turmas', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
