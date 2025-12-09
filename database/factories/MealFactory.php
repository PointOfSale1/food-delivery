<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MealFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'        => $this->faker->words(3, true),
            'description' => $this->faker->sentence(),
            'ingredients' => implode(", ", $this->faker->words(5)),
            'price'       => $this->faker->randomFloat(2, 5, 40),
            'image'       => "https://picsum.photos/seed/" . uniqid() . "/400/300",
            'is_available' => $this->faker->boolean(90),
            'sort_order'  => $this->faker->numberBetween(1, 20),
        ];
    }
}
