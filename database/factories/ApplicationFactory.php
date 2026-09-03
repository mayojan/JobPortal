<?php

namespace Database\Factories;

use App\Models\Application;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Application>
 */
class ApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'job_id' => \App\Models\Job::factory(),
            'candidate_id' => \App\Models\Candidate::factory(),
            'status' => fake()->randomElement(['pending', 'accepted', 'rejected']),
        ];
    }
}
