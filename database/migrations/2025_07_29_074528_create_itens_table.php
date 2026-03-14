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
        Schema::create('itens', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->decimal('preco', 10, 2)->nullable()->comment('NULL ou 0 = Sob Consulta');
            $table->string('imagem')->nullable();
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');
            $table->enum('tipo', ['produto', 'servico'])->default('produto')->comment('Produto físico ou Serviço');
            $table->boolean('destaque')->default(false); // Destacar no site
            $table->integer('ordem')->default(0); // Ordem dentro da categoria
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            
            // Índices para performance em queries
            $table->index('categoria_id');
            $table->index('destaque');
            $table->index('tipo');
            $table->index('ordem');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
