<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    public function definition(): array
    {
        $price = $this->faker->randomFloat(2, 3, 40);
        $qty   = $this->faker->numberBetween(1, 5);

        return [
            'meal_name' => $this->faker->words(3, true),
            'meal_price'=> $price,
            'quantity'  => $qty,
            'subtotal'  => $price * $qty,
            'special_instructions' => $this->faker->boolean(10)
                ? $this->faker->sentence()
                : null,
        ];
    }
}
