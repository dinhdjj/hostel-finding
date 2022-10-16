<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Amenity>
 */
class AmenityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->randomElement($this->getAmenityNames()),
            'description' => $this->faker->optional()->sentence(),
            'created_at' => $this->faker->dateTimeBetween('-2 month', 'now'),
        ];
    }

    public function getAmenityNames(): array
    {
        return [
            'Wifi miễn phí',
            'Điều hòa',
            'Tủ lạnh',
            'Bếp',
            'Bồn tắm',
            'Tủ đồ',
            'Giường',
            'Tủ quần áo',
            'Bàn ăn',
            'Chỗ để xe',
            'Chỗ để xe máy',
            'Chỗ để ô tô',
            'Gần siêu thị',
            'Gần trường học',
            'Gần bệnh viện',
            'Gần công viên',
            'Gần chợ',
            'Gần trung tâm thành phố',
            'Gần trung tâm thương mại',
            'Gần thiên nhiên',
        ];
    }
}
