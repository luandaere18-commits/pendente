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
        Schema::create('turmas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');
            $table->foreignId('formador_id')->nullable()->constrained('formadores')
                ->onDelete('set null');
            $table->unsignedInteger('duracao_semanas')->nullable();
            $table->enum('status', ['planeada', 'inscricoes_abertas', 'em_andamento', 'concluida'])->default('planeada');
            $table->date('data_arranque');
            $table->json('dia_semana', ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo']);
            $table->enum('periodo', ['manhã', 'tarde', 'noite']);
            $table->time('hora_inicio')->nullable();   // Hora de início da aula
            $table->time('hora_fim')->nullable();      // Hora de fim da aula
            $table->timestamps();
            
            // Índices para performance em queries
            $table->index('curso_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('turmas');
    }

    
};
