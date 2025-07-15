<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Dish;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function createOrder(array $data, $userId)
    {
        return DB::transaction(function () use ($data, $userId) {
            $totalAmount = $this->calculateTotal($data['items']);

            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => $userId,
                'total_amount' => $totalAmount,
                'payment_method' => $data['payment_method'],
                'delivery_address' => $data['delivery_address'],
                'observations' => $data['observations'] ?? null,
            ]);

            $this->createOrderItems($order, $data['items']);

            return $order->load(['user', 'orderItems.dish']);
        });
    }

    public function updateOrder(Order $order, array $data)
    {
        return $order->update($data);
    }

    public function getUserOrders($userId)
    {
        return Order::where('user_id', $userId)
            ->with(['user', 'orderItems.dish'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getOrderById($orderId, $userId = null)
    {
        $query = Order::with(['user', 'orderItems.dish']);

        if ($userId) {
            $query->where('user_id', $userId);
        }

        return $query->findOrFail($orderId);
    }

    private function calculateTotal(array $items): float
    {
        $total = 0;

        foreach ($items as $item) {
            $dish = Dish::findOrFail($item['dish_id']);
            $total += $dish->price * $item['quantity'];
        }

        return $total;
    }

    private function createOrderItems(Order $order, array $items)
    {
        foreach ($items as $item) {
            $dish = Dish::findOrFail($item['dish_id']);

            OrderItem::create([
                'order_id' => $order->id,
                'dish_id' => $item['dish_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $dish->price,
                'special_instructions' => $item['special_instructions'] ?? null,
            ]);
        }
    }

    public function updateOrderStatus(Order $order, string $status)
    {
        return $order->update(['status' => $status]);
    }

    public function updatePaymentStatus(Order $order, string $paymentStatus)
    {
        return $order->update(['payment_status' => $paymentStatus]);
    }
}
