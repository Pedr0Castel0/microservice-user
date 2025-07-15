<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'order_number' => $this->order_number,
            'customer' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
            ],
            'total_amount' => [
                'value' => $this->total_amount,
                'formatted' => 'R$ ' . number_format($this->total_amount, 2, ',', '.'),
            ],
            'status' => [
                'value' => $this->status,
                'label' => $this->getStatusLabel(),
                'description' => $this->getStatusDescription(),
            ],
            'payment' => [
                'method' => $this->payment_method,
                'method_label' => $this->getPaymentMethodLabel(),
                'status' => $this->payment_status,
                'status_label' => $this->payment_status === 'pago' ? 'Pago' : 'Pendente',
            ],
            'delivery_address' => $this->delivery_address,
            'observations' => $this->observations,
            'items' => $this->whenLoaded('orderItems', function () {
                return $this->orderItems->map(function ($item) {
                    return [
                        'dish' => [
                            'id' => $item->dish->id,
                            'name' => $item->dish->name,
                            'description' => $item->dish->description,
                        ],
                        'quantity' => $item->quantity,
                        'unit_price' => [
                            'value' => $item->unit_price,
                            'formatted' => 'R$ ' . number_format($item->unit_price, 2, ',', '.'),
                        ],
                        'subtotal' => [
                            'value' => $item->quantity * $item->unit_price,
                            'formatted' => 'R$ ' . number_format($item->quantity * $item->unit_price, 2, ',', '.'),
                        ],
                        'special_instructions' => $item->special_instructions,
                    ];
                });
            }),
            'created_at' => $this->created_at->format('d/m/Y H:i:s'),
            'updated_at' => $this->updated_at->format('d/m/Y H:i:s'),
        ];
    }

    private function getStatusLabel(): string
    {
        return match ($this->status) {
            'confirmado' => 'Confirmado',
            'em_preparo' => 'Em Preparo',
            'saiu_entrega' => 'Saiu para Entrega',
            'entregue' => 'Entregue',
            default => 'Status Indefinido',
        };
    }

    private function getStatusDescription(): string
    {
        return match ($this->status) {
            'confirmado' => 'Seu pedido foi confirmado e está sendo preparado',
            'em_preparo' => 'Seu pedido está sendo preparado na cozinha',
            'saiu_entrega' => 'Seu pedido saiu para entrega',
            'entregue' => 'Seu pedido foi entregue com sucesso',
            default => 'Status não definido',
        };
    }

    private function getPaymentMethodLabel(): string
    {
        return match ($this->payment_method) {
            'dinheiro' => 'Dinheiro',
            'pix' => 'PIX',
            'cartao_debito' => 'Cartão de Débito',
            'cartao_credito' => 'Cartão de Crédito',
            default => 'Método não definido',
        };
    }
}
