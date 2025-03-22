<?php

namespace Database\Factories;

use App\Models\Person;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    protected $model = Tag::class;

    public function definition()
    {
        return [
            'person_id' => Person::factory(), // Crea una persona si no se proporciona una
            'tipo' => $this->faker->randomElement(['views', 'category', 'label']),
            'valor' => $this->faker->word(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
