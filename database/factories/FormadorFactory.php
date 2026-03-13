<?php

namespace Database\Factories;

use App\Models\Formador;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Formador>
 */
class FormadorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Formador::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => $this->faker->name(),
            'email' => $this->faker->unique()->email(),
            'contactos' => json_encode([
                'telefone' => $this->faker->phoneNumber(),
                'telefone_alternativo' => $this->faker->phoneNumber()
            ]),
            'especialidade' => $this->faker->jobTitle(),
            'bio' => $this->faker->paragraph(),
            'foto_url' => $this->faker->imageUrl(),
        ];
    }
}