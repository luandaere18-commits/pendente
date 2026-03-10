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
            // Curso 1 - Multiple schedules (seg, qua, sex)
            $cronogramas[] = ['curso_id' => $cursoIds[0], 'dia_semana' => json_encode(['Segunda', 'Quarta', 'Sexta']), 'periodo' => 'manhã', 'hora_inicio' => '07:30', 'hora_fim' => '09:30', 'created_at' => $now, 'updated_at' => $now];
        }
        
        if (isset($cursoIds[1])) {
            // Curso 2 - Afternoon schedule (ter, qui)
            $cronogramas[] = ['curso_id' => $cursoIds[1], 'dia_semana' => json_encode(['Terça', 'Quinta']), 'periodo' => 'tarde', 'hora_inicio' => '13:00', 'hora_fim' => '15:00', 'created_at' => $now, 'updated_at' => $now];
        }
        
        if (isset($cursoIds[2])) {
            // Curso 3 - Night schedule (seg, qua, sex)
            $cronogramas[] = ['curso_id' => $cursoIds[2], 'dia_semana' => json_encode(['Segunda', 'Quarta', 'Sexta']), 'periodo' => 'noite', 'hora_inicio' => '18:30', 'hora_fim' => '20:30', 'created_at' => $now, 'updated_at' => $now];
        }
        
        if (isset($cursoIds[3])) {
            // Curso 4 - Morning schedule (ter, qui)
            $cronogramas[] = ['curso_id' => $cursoIds[3], 'dia_semana' => json_encode(['Terça', 'Quinta']), 'periodo' => 'manhã', 'hora_inicio' => '08:00', 'hora_fim' => '10:00', 'created_at' => $now, 'updated_at' => $now];
        }
        
        if (isset($cursoIds[4])) {
            // Curso 5 - Afternoon schedule (seg, qua, sex)
            $cronogramas[] = ['curso_id' => $cursoIds[4], 'dia_semana' => json_encode(['Segunda', 'Quarta', 'Sexta']), 'periodo' => 'tarde', 'hora_inicio' => '12:30', 'hora_fim' => '14:30', 'created_at' => $now, 'updated_at' => $now];
        }
        
        if (isset($cursoIds[5])) {
            // Curso 6 - Weekend schedule (sábado)
            $cronogramas[] = ['curso_id' => $cursoIds[5], 'dia_semana' => json_encode(['Sábado']), 'periodo' => 'manhã', 'hora_inicio' => '08:00', 'hora_fim' => '10:00', 'created_at' => $now, 'updated_at' => $now];
            $cronogramas[] = ['curso_id' => $cursoIds[5], 'dia_semana' => json_encode(['Sábado']), 'periodo' => 'tarde', 'hora_inicio' => '14:00', 'hora_fim' => '16:00', 'created_at' => $now, 'updated_at' => $now];
        }
        
        if (isset($cursoIds[6])) {
            // Curso 7 - Weekend schedule (domingo)
            $cronogramas[] = ['curso_id' => $cursoIds[6], 'dia_semana' => json_encode(['Domingo']), 'periodo' => 'manhã', 'hora_inicio' => '10:00', 'hora_fim' => '12:00', 'created_at' => $now, 'updated_at' => $now];
        }
        
        if (!empty($cronogramas)) {
            Cronograma::insert($cronogramas);
        }
    }
}
