<?php

namespace Database\Factories;

use App\Models\JobListing;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobListingFactory extends Factory
{
    protected $model = JobListing::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->jobTitle(),
            'description' => $this->faker->paragraph(),
            'company' => $this->faker->company(),
            'salary' => $this->faker->numberBetween(50000, 500000),
            'location' => $this->faker->city(),
            'type' => $this->faker->randomElement(['Full-time', 'Part-time', 'Remote', 'Internship']),
            'is_for_students' => $this->faker->boolean(70),
        ];
    }
}