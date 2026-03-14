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
        // Migration vazia - a estrutura foi criada corretamente na migration original
        // Schema::table('categorias', function (Blueprint $table) {
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Nada a reverter
    }
};
