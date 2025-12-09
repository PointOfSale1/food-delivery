<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'        => ucfirst($this->faker->word()),
            'description' => $this->faker->sentence(),
            'sort_order'  => $this->faker->numberBetween(1, 20),
            'is_active'   => true,
        ];
    }
}
