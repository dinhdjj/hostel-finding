<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hostel>
 */
class HostelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->name(),
            'description' => $this->faker->text(),
            'found_at' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'address' => $this->faker->address(),
            'longitude' => $this->faker->longitude(104.9, 107.9), // around Ho Chi Minh City
            'latitude' => $this->faker->latitude(9.6, 11.5), // around Ho Chi Minh City
            'size' => $this->faker->numberBetween(20, 200),
            'monthly_price' => 100000 * $this->faker->numberBetween(100, 1000),
            'allowable_number_of_people' => $this->faker->numberBetween(1, 10),
            'owner_id' => User::factory(),
            'created_at' => $this->faker->dateTimeBetween('-2 month', 'now'),
        ];
    }
}
