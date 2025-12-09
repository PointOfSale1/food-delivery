<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'customer_name'   => $this->faker->name(),
            'customer_phone'  => $this->faker->phoneNumber(),
            'customer_email'  => $this->faker->safeEmail(),
            'delivery_address'=> $this->faker->address(),
            'city'            => $this->faker->city(),
            'notes'           => $this->faker->sentence(),
            'subtotal'        => $this->faker->randomFloat(2, 10, 150),
            'delivery_fee'    => $this->faker->randomFloat(2, 0, 10),
            'total'           => $this->faker->randomFloat(2, 10, 160),
            'status'          => 'pending',
            'payment_method'  => 'cash',
            'payment_status'  => 'unpaid',
        ];
    }
}
