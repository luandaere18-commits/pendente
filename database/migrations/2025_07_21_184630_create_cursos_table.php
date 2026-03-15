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
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100);  // Nome do curso
            $table->text('descricao')->nullable();  // Descrição detalhada
            $table->text('programa')->nullable();  // Programa/Módulos
            $table->string('area', 100);  // Área de conhecimento
            $table->string('imagem_url')->nullable();  // URL da imagem do curso
            $table->boolean('ativo')->default(true);  // Status ativo/inativo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
