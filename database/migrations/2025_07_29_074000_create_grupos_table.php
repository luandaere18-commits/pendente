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
        Schema::create('grupos', function (Blueprint $table) {
            $table->id();
            $table->string('nome'); // snackbar, produtos, servicos
            $table->string('display_name'); // Snackbar, Produtos, Serviços
            $table->string('icone')->nullable(); // fas fa-utensils, fas fa-box, fas fa-cogs
            $table->integer('ordem')->default(0); // Ordem de exibição
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            
            $table->unique('nome');
            $table->index('ordem');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('grupos');
        Schema::enableForeignKeyConstraints();
    }
};
