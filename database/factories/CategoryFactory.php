<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->randomElement($this->getCategoryNames()),
            'description' => $this->faker->optional()->sentence(),
            'created_at' => $this->faker->dateTimeBetween('-2 month', 'now'),
        ];
    }

    public function getCategoryNames(): array
    {
        return [
            'Tìm người ở ghép',
            'Nhà trọ OU',
            'Nhà trọ TDT',
            'Nhà trọ ĐHSP',
            'Nhà trọ ĐHĐN',
            'Nhà trọ sinh viên',
            'Chung cư mini',
            'Chung cư nguyên căn',
            'Nhà riêng',
            'Biệt thự',
            'Căn hộ',
            'Khách sạn',
            'Nhà nghỉ',
        ];
    }
}
