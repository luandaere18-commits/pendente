<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Criar nova coluna como JSON temporária
        Schema::table('cronogramas', function (Blueprint $table) {
            $table->json('dia_semana_json')->nullable()->after('curso_id');
        });
        
        // Converter dados de enum para array JSON
        DB::statement("
            UPDATE cronogramas 
            SET dia_semana_json = JSON_ARRAY(dia_semana)
            WHERE dia_semana IS NOT NULL
        ");
        
        // Remover coluna antiga
        Schema::table('cronogramas', function (Blueprint $table) {
            $table->dropColumn('dia_semana');
        });
        
        // Renomear coluna nova usando raw SQL
        DB::statement("
            ALTER TABLE cronogramas 
            CHANGE dia_semana_json dia_semana JSON NULL
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Criar coluna enum temporária
        Schema::table('cronogramas', function (Blueprint $table) {
            $table->enum('dia_semana_enum', ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'])->nullable()->after('curso_id');
        });
        
        // Converter primeiro elemento do JSON para enum
        DB::statement("
            UPDATE cronogramas 
            SET dia_semana_enum = JSON_UNQUOTE(JSON_EXTRACT(dia_semana, '$[0]'))
            WHERE dia_semana IS NOT NULL
        ");
        
        // Remover coluna JSON
        Schema::table('cronogramas', function (Blueprint $table) {
            $table->dropColumn('dia_semana');
        });
        
        // Renomear coluna enum de volta usando raw SQL
        DB::statement("
            ALTER TABLE cronogramas 
            CHANGE dia_semana_enum dia_semana ENUM('Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo') NULL
        ");
    }
};

