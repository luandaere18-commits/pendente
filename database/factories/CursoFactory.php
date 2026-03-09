<?php

namespace Database\Factories;

use App\Models\Curso;
use Illuminate\Database\Eloquent\Factories\Factory;

class CursoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Curso::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $areas = ['Tecnologia', 'Gestão', 'Idiomas', 'Ciências', 'Artes'];
        $modalidades = ['presencial', 'online'];

        return [
            'nome' => $this->faker->words(3, true),
            'descricao' => $this->faker->sentence(),
            'programa' => $this->faker->text(200),
            'area' => $this->faker->randomElement($areas),
            'modalidade' => $this->faker->randomElement($modalidades),
            'ativo' => true,
        ];
    }

    /**
     * Configure the factory to active courses
     */
    public function active(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'ativo' => true,
            ];
        });
    }

    /**
     * Configure the factory to inactive courses
     */
    public function inactive(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'ativo' => false,
            ];
        });
    }

    /**
     * Configure the factory for presencial courses
     */
    public function presencial(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'modalidade' => 'presencial',
            ];
        });
    }

    /**
     * Configure the factory for online courses
     */
    public function online(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'modalidade' => 'online',
            ];
        });
    }
}
