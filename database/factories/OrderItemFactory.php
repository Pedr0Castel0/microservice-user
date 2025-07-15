<?php

namespace Database\Factories;

use App\Models\Dish;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dish = Dish::inRandomOrder()->first();

        return [
            'order_id' => Order::factory(),
            'dish_id' => $dish?->id ?? Dish::factory(),
            'quantity' => $this->faker->numberBetween(1, 5),
            'unit_price' => $dish?->price ?? $this->faker->randomFloat(2, 10, 50),
            'special_instructions' => $this->faker->optional(0.3)->randomElement([
                'Sem pimenta',
                'Pouco sal',
                'Bem temperado',
                'Sem cebola',
                'Extra molho',
                'Sem coentro',
                'Pimenta à parte',
                'Pouco queijo',
                'Queijo extra'
            ])
        ];
    }
}
