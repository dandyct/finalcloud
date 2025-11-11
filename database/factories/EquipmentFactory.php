<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EquipmentFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->company . ' ' . $this->faker->word,
            'sku' => strtoupper(Str::random(8)),
            'description' => $this->faker->sentence,
            'price_per_day' => $this->faker->randomFloat(2, 50, 5000),
            'status' => 'available',
            'location' => $this->faker->city,
            'stock' => $this->faker->numberBetween(1, 5),
        ];
    }
}