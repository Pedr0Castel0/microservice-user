<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statuses = ['confirmado', 'em_preparo', 'saiu_entrega', 'entregue'];
        $paymentMethods = ['dinheiro', 'pix', 'cartao_debito', 'cartao_credito'];
        $paymentStatuses = ['pendente', 'pago'];

        return [
            'order_number' => 'ORD-' . now()->format('YmdHis') . '-' . str_pad(fake()->numberBetween(1, 9999), 4, '0', STR_PAD_LEFT),
            'user_id' => User::factory(),
            'total_amount' => fake()->randomFloat(2, 25.00, 150.00),
            'status' => fake()->randomElement($statuses),
            'payment_method' => fake()->randomElement($paymentMethods),
            'payment_status' => fake()->randomElement($paymentStatuses),
            'delivery_address' => [
                'street' => fake()->streetName(),
                'number' => fake()->buildingNumber(),
                'complement' => fake()->optional()->secondaryAddress(),
                'neighborhood' => fake()->citySuffix(),
                'city' => fake()->city(),
                'state' => fake()->stateAbbr(),
                'zip_code' => fake()->postcode()
            ],
            'observations' => fake()->optional()->sentence()
        ];
    }
}
