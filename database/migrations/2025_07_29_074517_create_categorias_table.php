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
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->foreignId('grupo_id')->constrained('grupos')->onDelete('cascade');
            $table->integer('ordem')->default(0); // Ordem dentro do grupo
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            
            // Índices para performance
            $table->index('grupo_id');
            $table->index('ordem');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('categorias');
        Schema::enableForeignKeyConstraints();
    }
};
