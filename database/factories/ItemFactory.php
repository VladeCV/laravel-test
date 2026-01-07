<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id' => Str::uuid(),
            'name' => $this->faker->words(2, true),
            'description' => $this->faker->sentence(),
            'code' => strtoupper($this->faker->unique()->bothify('ITEM-###')),
            'status' => 'active',
        ];
    }
}
