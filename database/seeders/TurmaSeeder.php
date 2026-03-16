<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Turma;
use App\Models\Curso;
use App\Models\Centro;
use App\Models\Formador;

class TurmaSeeder extends Seeder
{
    /**
     * Seed turmas com dados realistas para testes
     * Inclui múltiplos períodos (manha, tarde, noite)
     * dias da semana diferentes, e duração em semanas
     */
    public function run(): void
    {
        $centros = Centro::all();
        $cursos = Curso::all();
        $formadores = Formador::with('centros')->get();

        if ($centros->isEmpty() || $cursos->isEmpty()) {
            // Requer cursos e centros para criar turmas
            return;
        }

        $now = now();

        // Helper para escolher um formador disponível no centro
        $getFormadorId = function (int $centroId) use ($formadores) {
            $disponiveis = $formadores->filter(function ($formador) use ($centroId) {
                return $formador->centros->contains('id', $centroId);
            })->pluck('id')->toArray();

            return count($disponiveis) ? $disponiveis[array_rand($disponiveis)] : null;
        };

        $turmas = [
            // Curso 1 (Informática Básica) em dois centros
            ['curso_nome' => 'Informática Básica', 'centro_id' => 1, 'duracao_semanas' => 4, 'dia_semana' => ['Segunda', 'Quarta', 'Sexta'], 'periodo' => 'manha', 'modalidade' => 'presencial', 'hora_inicio' => '07:30', 'hora_fim' => '09:30', 'data_arranque' => '2026-04-01', 'status' => 'inscricoes_abertas', 'vagas_totais' => 30, 'vagas_preenchidas' => 10, 'publicado' => true],
            ['curso_nome' => 'Informática Básica', 'centro_id' => 2, 'duracao_semanas' => 5, 'dia_semana' => ['Terça', 'Quinta'], 'periodo' => 'tarde', 'modalidade' => 'hibrido', 'hora_inicio' => '13:00', 'hora_fim' => '15:00', 'data_arranque' => '2026-04-05', 'status' => 'inscricoes_abertas', 'vagas_totais' => 25, 'vagas_preenchidas' => 18, 'publicado' => true],

            // Curso 2 (Gestão Empresarial)
            ['curso_nome' => 'Gestão Empresarial', 'centro_id' => 2, 'duracao_semanas' => 6, 'dia_semana' => ['Terça', 'Quinta'], 'periodo' => 'tarde', 'modalidade' => 'online', 'hora_inicio' => '14:00', 'hora_fim' => '16:00', 'data_arranque' => '2026-04-08', 'status' => 'planeada', 'vagas_totais' => 20, 'vagas_preenchidas' => 0, 'publicado' => false],
            ['curso_nome' => 'Gestão Empresarial', 'centro_id' => 3, 'duracao_semanas' => 5, 'dia_semana' => ['Segunda', 'Quarta'], 'periodo' => 'manha', 'modalidade' => 'presencial', 'hora_inicio' => '09:00', 'hora_fim' => '11:00', 'data_arranque' => '2026-04-15', 'status' => 'inscricoes_abertas', 'vagas_totais' => 30, 'vagas_preenchidas' => 12, 'publicado' => true],

            // Curso 3 (Inglês)
            ['curso_nome' => 'Inglês', 'centro_id' => 3, 'duracao_semanas' => 8, 'dia_semana' => ['Segunda', 'Quarta', 'Sexta'], 'periodo' => 'noite', 'modalidade' => 'online', 'hora_inicio' => '18:30', 'hora_fim' => '20:30', 'data_arranque' => '2026-04-08', 'status' => 'planeada', 'vagas_totais' => 20, 'vagas_preenchidas' => 0, 'publicado' => false],
            ['curso_nome' => 'Inglês', 'centro_id' => 1, 'duracao_semanas' => 6, 'dia_semana' => ['Terça', 'Quinta'], 'periodo' => 'tarde', 'modalidade' => 'hibrido', 'hora_inicio' => '15:00', 'hora_fim' => '17:00', 'data_arranque' => '2026-04-22', 'status' => 'inscricoes_abertas', 'vagas_totais' => 25, 'vagas_preenchidas' => 7, 'publicado' => true],

            // Curso 4 (Matemática Aplicada)
            ['curso_nome' => 'Matemática Aplicada', 'centro_id' => 1, 'duracao_semanas' => 5, 'dia_semana' => ['Terça', 'Quinta'], 'periodo' => 'manha', 'modalidade' => 'presencial', 'hora_inicio' => '08:00', 'hora_fim' => '10:00', 'data_arranque' => '2026-04-12', 'status' => 'em_andamento', 'vagas_totais' => 35, 'vagas_preenchidas' => 25, 'publicado' => true],
            ['curso_nome' => 'Matemática Aplicada', 'centro_id' => 2, 'duracao_semanas' => 10, 'dia_semana' => ['Segunda', 'Quarta', 'Sexta'], 'periodo' => 'tarde', 'modalidade' => 'online', 'hora_inicio' => '12:30', 'hora_fim' => '14:30', 'data_arranque' => '2026-04-15', 'status' => 'inscricoes_abertas', 'vagas_totais' => 40, 'vagas_preenchidas' => 5, 'publicado' => true],

            // Curso 5 (Programação Web)
            ['curso_nome' => 'Programação Web', 'centro_id' => 3, 'duracao_semanas' => 4, 'dia_semana' => ['Sábado'], 'periodo' => 'manha', 'modalidade' => 'hibrido', 'hora_inicio' => '08:00', 'hora_fim' => '10:00', 'data_arranque' => '2026-04-18', 'status' => 'planeada', 'vagas_totais' => 15, 'vagas_preenchidas' => 0, 'publicado' => false],
            ['curso_nome' => 'Programação Web', 'centro_id' => 3, 'duracao_semanas' => 4, 'dia_semana' => ['Sábado'], 'periodo' => 'tarde', 'modalidade' => 'presencial', 'hora_inicio' => '14:00', 'hora_fim' => '16:00', 'data_arranque' => '2026-04-25', 'status' => 'inscricoes_abertas', 'vagas_totais' => 20, 'vagas_preenchidas' => 8, 'publicado' => true],

            // Curso 6 (Contabilidade)
            ['curso_nome' => 'Contabilidade', 'centro_id' => 1, 'duracao_semanas' => 3, 'dia_semana' => ['Domingo'], 'periodo' => 'manha', 'modalidade' => 'online', 'hora_inicio' => '10:00', 'hora_fim' => '12:00', 'data_arranque' => '2026-05-01', 'status' => 'concluida', 'vagas_totais' => 25, 'vagas_preenchidas' => 25, 'publicado' => false],
        ];

        foreach ($turmas as $turmaConfig) {
            $curso = $cursos->firstWhere('nome', $turmaConfig['curso_nome']);
            if (!$curso) {
                continue;
            }

            $formadorId = $getFormadorId($turmaConfig['centro_id']);

            Turma::updateOrCreate(
                [
                    'curso_id' => $curso->id,
                    'centro_id' => $turmaConfig['centro_id'],
                    'data_arranque' => $turmaConfig['data_arranque'],
                    'hora_inicio' => $turmaConfig['hora_inicio'],
                ],
                [
                    'formador_id' => $formadorId,
                    'duracao_semanas' => $turmaConfig['duracao_semanas'],
                    'dia_semana' => $turmaConfig['dia_semana'],
                    'periodo' => $turmaConfig['periodo'],
                    'hora_fim' => $turmaConfig['hora_fim'],
                    'status' => $turmaConfig['status'],
                    'vagas_totais' => $turmaConfig['vagas_totais'],
                    'vagas_preenchidas' => $turmaConfig['vagas_preenchidas'],
                    'publicado' => $turmaConfig['publicado'],
                    'updated_at' => $now,
                    'created_at' => $now,
                ]
            );
        }
    }
}
