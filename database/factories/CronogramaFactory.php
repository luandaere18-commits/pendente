<?php

namespace Database\Factories;

use App\Models\Cronograma;
use App\Models\Curso;
use Illuminate\Database\Eloquent\Factories\Factory;

class CronogramaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cronograma::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $periodos = ['manhã', 'tarde', 'noite'];
        $dias = ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'];
        
        $periodo = $this->faker->randomElement($periodos);
        
        // Gerar horas válidas para o período
        $horas = match($periodo) {
            'manhã' => [8, 9, 10, 11],
            'tarde' => [12, 13, 14, 15, 16, 17],
            'noite' => [18, 19, 20, 21]
        };
        
        $horaInicio = $this->faker->randomElement($horas);
        $horaFim = $horaInicio + $this->faker->numberBetween(1, 3);
        
        return [
            'curso_id' => Curso::factory(),
            'dia_semana' => $this->faker->randomElement($dias),
            'periodo' => $periodo,
            'hora_inicio' => sprintf('%02d:00', $horaInicio),
            'hora_fim' => sprintf('%02d:00', min($horaFim, 23)),
        ];
    }

    /**
     * Gerar cronograma para período da manhã
     */
    public function manha(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'periodo' => 'manhã',
                'hora_inicio' => '08:' . $this->faker->numberBetween(0, 59),
                'hora_fim' => '10:' . $this->faker->numberBetween(0, 59),
            ];
        });
    }

    /**
     * Gerar cronograma para período da tarde
     */
    public function tarde(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'periodo' => 'tarde',
                'hora_inicio' => '13:' . $this->faker->numberBetween(0, 59),
                'hora_fim' => '16:' . $this->faker->numberBetween(0, 59),
            ];
        });
    }

    /**
     * Gerar cronograma para período da noite
     */
    public function noite(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'periodo' => 'noite',
                'hora_inicio' => '18:' . $this->faker->numberBetween(0, 59),
                'hora_fim' => '20:' . $this->faker->numberBetween(0, 59),
            ];
        });
    }

    /**
     * Gerar cronograma para um curso específico
     */
    public function forCurso(Curso $curso): static
    {
        return $this->state(function (array $attributes) use ($curso) {
            return [
                'curso_id' => $curso->id,
            ];
        });
    }

    /**
     * Gerar cronograma para um dia específico
     */
    public function forDia(string $dia): static
    {
        return $this->state(function (array $attributes) use ($dia) {
            return [
                'dia_semana' => $dia,
            ];
        });
    }
}
