<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Turma;
use App\Models\Curso;

class TurmaSeeder extends Seeder
{
    /**
     * Seed turmas com dados realistas para testes
     * Inclui múltiplos períodos (manhã, tarde, noite)
     * dias da semana diferentes, e duração em semanas
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
        $turmas = [];
        
        if (isset($cursoIds[0])) {
            // Turma 1 - Multiple schedules (seg, qua, sex) - 4 semanas
            $turmas[] = ['curso_id' => $cursoIds[0], 'duracao_semanas' => 4, 'dia_semana' => json_encode(['Segunda', 'Quarta', 'Sexta']), 'periodo' => 'manhã', 'hora_inicio' => '07:30', 'hora_fim' => '09:30', 'data_arranque' => '2026-04-01', 'status' => 'inscricoes_abertas', 'created_at' => $now, 'updated_at' => $now];
        }
        
        if (isset($cursoIds[1])) {
            // Turma 2 - Afternoon schedule (ter, qui) - 6 semanas
            $turmas[] = ['curso_id' => $cursoIds[1], 'duracao_semanas' => 6, 'dia_semana' => json_encode(['Terça', 'Quinta']), 'periodo' => 'tarde', 'hora_inicio' => '13:00', 'hora_fim' => '15:00', 'data_arranque' => '2026-04-05', 'status' => 'inscricoes_abertas', 'created_at' => $now, 'updated_at' => $now];
        }
        
        if (isset($cursoIds[2])) {
            // Turma 3 - Night schedule (seg, qua, sex) - 8 semanas
            $turmas[] = ['curso_id' => $cursoIds[2], 'duracao_semanas' => 8, 'dia_semana' => json_encode(['Segunda', 'Quarta', 'Sexta']), 'periodo' => 'noite', 'hora_inicio' => '18:30', 'hora_fim' => '20:30', 'data_arranque' => '2026-04-08', 'status' => 'planeada', 'created_at' => $now, 'updated_at' => $now];
        }
        
        if (isset($cursoIds[3])) {
            // Turma 4 - Morning schedule (ter, qui) - 5 semanas
            $turmas[] = ['curso_id' => $cursoIds[3], 'duracao_semanas' => 5, 'dia_semana' => json_encode(['Terça', 'Quinta']), 'periodo' => 'manhã', 'hora_inicio' => '08:00', 'hora_fim' => '10:00', 'data_arranque' => '2026-04-12', 'status' => 'em_andamento', 'created_at' => $now, 'updated_at' => $now];
        }
        
        if (isset($cursoIds[4])) {
            // Turma 5 - Afternoon schedule (seg, qua, sex) - 10 semanas
            $turmas[] = ['curso_id' => $cursoIds[4], 'duracao_semanas' => 10, 'dia_semana' => json_encode(['Segunda', 'Quarta', 'Sexta']), 'periodo' => 'tarde', 'hora_inicio' => '12:30', 'hora_fim' => '14:30', 'data_arranque' => '2026-04-15', 'status' => 'inscricoes_abertas', 'created_at' => $now, 'updated_at' => $now];
        }
        
        if (isset($cursoIds[5])) {
            // Turma 6 - Weekend schedule morning (sábado) - 4 semanas
            $turmas[] = ['curso_id' => $cursoIds[5], 'duracao_semanas' => 4, 'dia_semana' => json_encode(['Sábado']), 'periodo' => 'manhã', 'hora_inicio' => '08:00', 'hora_fim' => '10:00', 'data_arranque' => '2026-04-18', 'status' => 'planeada', 'created_at' => $now, 'updated_at' => $now];
            // Turma 6b - Weekend schedule afternoon (sábado) - 4 semanas (pode ser turma diferente)
            $turmas[] = ['curso_id' => $cursoIds[5], 'duracao_semanas' => 4, 'dia_semana' => json_encode(['Sábado']), 'periodo' => 'tarde', 'hora_inicio' => '14:00', 'hora_fim' => '16:00', 'data_arranque' => '2026-04-25', 'status' => 'inscricoes_abertas', 'created_at' => $now, 'updated_at' => $now];
        }
        
        if (isset($cursoIds[6])) {
            // Turma 7 - Weekend schedule Sunday - 3 semanas
            $turmas[] = ['curso_id' => $cursoIds[6], 'duracao_semanas' => 3, 'dia_semana' => json_encode(['Domingo']), 'periodo' => 'manhã', 'hora_inicio' => '10:00', 'hora_fim' => '12:00', 'data_arranque' => '2026-05-01', 'status' => 'concluida', 'created_at' => $now, 'updated_at' => $now];
        }
        
        if (!empty($turmas)) {
            Turma::insert($turmas);
        }
    }
}
