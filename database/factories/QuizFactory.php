<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quiz>
 */
class QuizFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "title" => $this->faker->sentence(),
            "duration" => $this->faker->randomNumber(3),
            "status" => $this->faker->randomElement(["active", "inactive"]),
            "max_score" => $this->faker->numberBetween(0, 20),
        ];
    }
}
