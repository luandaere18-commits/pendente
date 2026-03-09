<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cronograma;
use App\Models\Curso;

class CronogramaSeeder extends Seeder
{
    /**
     * Seed cronogramas com dados realistas para testes
     * Inclui múltiplos períodos (manhã, tarde, noite)
     * e dias da semana diferentes
     */
    public function run(): void
    {
        // Verificar se existem cursos, se não, criar
        $cursos = Curso::all();
        
        if ($cursos->isEmpty()) {
            // Se não há cursos, criar alguns para o seeding
            $cursoIds = [];
            for ($i = 1; $i <= 7; $i++) {
                $curso = Curso::create([
                    'nome' => "Curso $i",
                    'area' => "Área $i",
                    'modalidade' => $i % 2 === 0 ? 'online' : 'presencial',
                    'ativo' => true
                ]);
                $cursoIds[] = $curso->id;
            }
        } else {
            $cursoIds = $cursos->pluck('id')->toArray();
        }

        // Se não temos IDs suficientes, usar os que temos
        $cursoIds = array_slice($cursoIds, 0, 7);
        
        $now = now();
        $cronogramas = [];
        
        if (isset($cursoIds[0])) {
            // Curso 1 - Multiple schedules
            $cronogramas[] = ['curso_id' => $cursoIds[0], 'dia_semana' => 'Segunda', 'periodo' => 'manhã', 'hora_inicio' => '08:00', 'hora_fim' => '10:00', 'created_at' => $now, 'updated_at' => $now];
            $cronogramas[] = ['curso_id' => $cursoIds[0], 'dia_semana' => 'Quarta', 'periodo' => 'manhã', 'hora_inicio' => '08:30', 'hora_fim' => '10:30', 'created_at' => $now, 'updated_at' => $now];
            $cronogramas[] = ['curso_id' => $cursoIds[0], 'dia_semana' => 'Sexta', 'periodo' => 'manhã', 'hora_inicio' => '09:00', 'hora_fim' => '11:00', 'created_at' => $now, 'updated_at' => $now];
        }
        
        if (isset($cursoIds[1])) {
            // Curso 2 - Afternoon schedule
            $cronogramas[] = ['curso_id' => $cursoIds[1], 'dia_semana' => 'Terça', 'periodo' => 'tarde', 'hora_inicio' => '14:00', 'hora_fim' => '16:00', 'created_at' => $now, 'updated_at' => $now];
            $cronogramas[] = ['curso_id' => $cursoIds[1], 'dia_semana' => 'Quinta', 'periodo' => 'tarde', 'hora_inicio' => '13:00', 'hora_fim' => '15:00', 'created_at' => $now, 'updated_at' => $now];
        }
        
        if (isset($cursoIds[2])) {
            // Curso 3 - Night schedule
            $cronogramas[] = ['curso_id' => $cursoIds[2], 'dia_semana' => 'Segunda', 'periodo' => 'noite', 'hora_inicio' => '19:00', 'hora_fim' => '21:00', 'created_at' => $now, 'updated_at' => $now];
            $cronogramas[] = ['curso_id' => $cursoIds[2], 'dia_semana' => 'Quarta', 'periodo' => 'noite', 'hora_inicio' => '18:00', 'hora_fim' => '20:00', 'created_at' => $now, 'updated_at' => $now];
            $cronogramas[] = ['curso_id' => $cursoIds[2], 'dia_semana' => 'Sexta', 'periodo' => 'noite', 'hora_inicio' => '20:00', 'hora_fim' => '21:30', 'created_at' => $now, 'updated_at' => $now];
        }
        
        if (isset($cursoIds[3])) {
            // Curso 4
            $cronogramas[] = ['curso_id' => $cursoIds[3], 'dia_semana' => 'Terça', 'periodo' => 'manhã', 'hora_inicio' => '10:00', 'hora_fim' => '12:00', 'created_at' => $now, 'updated_at' => $now];
            $cronogramas[] = ['curso_id' => $cursoIds[3], 'dia_semana' => 'Quinta', 'periodo' => 'manhã', 'hora_inicio' => '08:00', 'hora_fim' => '10:00', 'created_at' => $now, 'updated_at' => $now];
        }
        
        if (isset($cursoIds[4])) {
            // Curso 5
            $cronogramas[] = ['curso_id' => $cursoIds[4], 'dia_semana' => 'Segunda', 'periodo' => 'tarde', 'hora_inicio' => '15:00', 'hora_fim' => '17:00', 'created_at' => $now, 'updated_at' => $now];
            $cronogramas[] = ['curso_id' => $cursoIds[4], 'dia_semana' => 'Quarta', 'periodo' => 'tarde', 'hora_inicio' => '12:00', 'hora_fim' => '14:00', 'created_at' => $now, 'updated_at' => $now];
            $cronogramas[] = ['curso_id' => $cursoIds[4], 'dia_semana' => 'Sexta', 'periodo' => 'tarde', 'hora_inicio' => '15:30', 'hora_fim' => '17:30', 'created_at' => $now, 'updated_at' => $now];
        }
        
        if (isset($cursoIds[5])) {
            // Curso 6
            $cronogramas[] = ['curso_id' => $cursoIds[5], 'dia_semana' => 'Sábado', 'periodo' => 'manhã', 'hora_inicio' => '08:00', 'hora_fim' => '10:00', 'created_at' => $now, 'updated_at' => $now];
            $cronogramas[] = ['curso_id' => $cursoIds[5], 'dia_semana' => 'Sábado', 'periodo' => 'tarde', 'hora_inicio' => '14:00', 'hora_fim' => '16:00', 'created_at' => $now, 'updated_at' => $now];
        }
        
        if (isset($cursoIds[6])) {
            // Curso 7
            $cronogramas[] = ['curso_id' => $cursoIds[6], 'dia_semana' => 'Domingo', 'periodo' => 'manhã', 'hora_inicio' => '10:00', 'hora_fim' => '12:00', 'created_at' => $now, 'updated_at' => $now];
            $cronogramas[] = ['curso_id' => $cursoIds[6], 'dia_semana' => 'Domingo', 'periodo' => 'tarde', 'hora_inicio' => '14:00', 'hora_fim' => '16:00', 'created_at' => $now, 'updated_at' => $now];
        }
        
        if (!empty($cronogramas)) {
            Cronograma::insert($cronogramas);
        }
    }
}
