<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RestaurantFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'        => $this->faker->company,
            'email'       => $this->faker->unique()->safeEmail(),
            'password'    => 'password123', // automatically hashed in model
            'phone'       => $this->faker->phoneNumber(),
            'address'     => $this->faker->address(),
            'city'        => $this->faker->city(),
            'description' => $this->faker->sentence(),
            'logo'        => null,
            'status'      => 'active',
        ];
    }
}
