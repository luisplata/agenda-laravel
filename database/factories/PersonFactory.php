<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Person>
 */
class PersonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->name(),
            'about' => $this->faker->paragraph(),
            'horario' => $this->faker->randomElement(['Mañana', 'Tarde', 'Noche']),
            'tarifa' => $this->faker->randomFloat(2, 10, 500),
            'whatsapp' => $this->faker->phoneNumber(),
            'telegram' => '@' . $this->faker->userName(),
            'mapa' => 'https://maps.google.com/?q=' . $this->faker->latitude() . ',' . $this->faker->longitude(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
