<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('turmas', function (Blueprint $table) {
            $table->foreignId('formador_id')
                ->nullable()
                ->constrained('formadores')
                ->onDelete('set null')
                ->after('curso_id');
        });
    }

    public function down(): void
    {
        Schema::table('turmas', function (Blueprint $table) {
            $table->dropForeignKeyConstraints();
            $table->dropColumn('formador_id');
        });
    }
};
