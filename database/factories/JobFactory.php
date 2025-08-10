<?php

namespace Database\Factories;

use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Job::class;
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->jobTitle,
            'description' => $this->faker->paragraph,
            'type' => $this->faker->randomElement(['full-time', 'part-time', 'contract', 'freelance', 'internship']),
            'salary' => $this->faker->numberBetween(30000, 120000),
            'expiration_date' => $this->faker->date,
            'status' => 'pending',
        ];
    }
}
