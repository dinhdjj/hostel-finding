<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Hostel;
use App\Models\User;
use Arr;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'content' => $this->faker->sentence(),
            'parent_id' => fn ($attrs) => Arr::random([null, Comment::factory(['hostel_id' => $attrs['hostel_id']])]),
            'owner_id' => User::factory(),
            'hostel_id' => Hostel::factory(),
        ];
    }
}
