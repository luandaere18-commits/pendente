<?php

namespace Database\Factories;

use App\Models\Centro;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Centro>
 */
class CentroFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Centro::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => $this->faker->company() . ' Centro',
            'localizacao' => $this->faker->address(),
            'contactos' => json_encode([
                'telefone' => $this->faker->phoneNumber(),
                'telefone_alternativo' => $this->faker->phoneNumber()
            ]),
            'email' => $this->faker->email(),
        ];
    }
}