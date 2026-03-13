<?php

namespace Database\Factories;

use App\Models\Turma;
use App\Models\Curso;
use App\Models\Centro;
use App\Models\Formador;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Turma>
 */
class TurmaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Turma::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Create or get existing related models
        $curso = Curso::inRandomOrder()->first();
        if (!$curso) {
            $curso = Curso::factory()->create();
        }

        $centro = Centro::inRandomOrder()->first();
        if (!$centro) {
            $centro = Centro::factory()->create();
        }

        // Ensure the relationship exists in centro_curso table
        if (!$centro->cursos()->where('cursos.id', $curso->id)->exists()) {
            \DB::table('centro_curso')->insert([
                'centro_id' => $centro->id,
                'curso_id' => $curso->id,
                'preco' => $this->faker->randomFloat(2, 100, 500),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        $formador = Formador::inRandomOrder()->first();

        $periodos = ['manhã', 'tarde', 'noite'];
        $periodo = $this->faker->randomElement($periodos);

        $horaInicio = match ($periodo) {
            'manhã' => $this->faker->time('H:i', '11:59'),
            'tarde' => $this->faker->time('H:i', '17:59'),
            'noite' => $this->faker->time('H:i', '21:59'),
        };

        $horaFim = date('H:i', strtotime($horaInicio) + rand(1, 3) * 3600); // 1-3 horas depois

        return [
            'curso_id' => $curso->id,
            'centro_id' => $centro->id,
            'formador_id' => $formador?->id,
            'data_arranque' => $this->faker->dateTimeBetween('now', '+6 months')->format('Y-m-d'),
            'duracao_semanas' => $this->faker->numberBetween(4, 12),
            'dia_semana' => $this->faker->randomElements(['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'], rand(1, 3)),
            'periodo' => $periodo,
            'hora_inicio' => $horaInicio,
            'hora_fim' => $horaFim,
            'status' => $this->faker->randomElement(['planeada', 'inscricoes_abertas', 'em_andamento', 'concluida']),
            'vagas_totais' => $this->faker->numberBetween(10, 50),
            'publicado' => $this->faker->boolean(),
        ];
    }
}