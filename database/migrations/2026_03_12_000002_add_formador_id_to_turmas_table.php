<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Adicionar coluna formador_id à tabela turmas
     */
    public function up(): void
    {
        Schema::table('turmas', function (Blueprint $table) {
            if (!Schema::hasColumn('turmas', 'formador_id')) {
                $table->foreignId('formador_id')
                    ->nullable()
                    ->constrained('formadores')
                    ->onDelete('set null')
                    ->after('curso_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('turmas', function (Blueprint $table) {
            if (Schema::hasColumn('turmas', 'formador_id')) {
                $table->dropConstrainedForeignId('formador_id');
            }
        });
    }
};
