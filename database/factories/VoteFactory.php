<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Hostel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vote>
 */
class VoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'score' => $this->faker->numberBetween(0, 10) * 0.1,
            'description' => $this->faker->optional()->sentence(),
            'owner_id' => User::factory(),
            'hostel_id' => Hostel::factory(),
        ];
    }
}
