<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class PaymentMethodController extends Controller
{
    use ResponseTrait;

    public function index(): JsonResponse
    {
        $paymentMethods = [
            [
                'id' => 'dinheiro',
                'name' => 'Dinheiro',
                'description' => 'Pagamento em dinheiro na entrega',
                'icon' => 'cash',
                'available' => true,
                'requires_change' => true
            ],
            [
                'id' => 'pix',
                'name' => 'PIX',
                'description' => 'Pagamento via PIX na entrega',
                'icon' => 'pix',
                'available' => true,
                'requires_change' => false
            ],
            [
                'id' => 'cartao_debito',
                'name' => 'Cartão de Débito',
                'description' => 'Pagamento com cartão de débito na entrega',
                'icon' => 'debit-card',
                'available' => true,
                'requires_change' => false
            ],
            [
                'id' => 'cartao_credito',
                'name' => 'Cartão de Crédito',
                'description' => 'Pagamento com cartão de crédito na entrega',
                'icon' => 'credit-card',
                'available' => true,
                'requires_change' => false
            ]
        ];

        return $this->success($paymentMethods, 'Métodos de pagamento recuperados com sucesso');
    }
}
