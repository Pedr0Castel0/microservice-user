<?php

namespace App\Http\Controllers\Api;

use App\Enums\PaymentMethod;
use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class PaymentMethodController extends Controller
{
    use ResponseTrait;

    public function index(): JsonResponse
    {
        $paymentMethods = [];

        foreach (PaymentMethod::cases() as $method) {
            $paymentMethods[] = [
                'id' => $method->value,
                'name' => $method->label(),
                'description' => $this->getMethodDescription($method),
                'icon' => $this->getMethodIcon($method),
                'available' => true,
                'requires_change' => $method === PaymentMethod::DINHEIRO
            ];
        }

        return $this->success($paymentMethods, 'Métodos de pagamento recuperados com sucesso');
    }

    private function getMethodDescription(PaymentMethod $method): string
    {
        return match ($method) {
            PaymentMethod::DINHEIRO => 'Pagamento em dinheiro na entrega',
            PaymentMethod::PIX => 'Pagamento via PIX na entrega',
            PaymentMethod::CARTAO_DEBITO => 'Pagamento com cartão de débito na entrega',
            PaymentMethod::CARTAO_CREDITO => 'Pagamento com cartão de crédito na entrega',
        };
    }

    private function getMethodIcon(PaymentMethod $method): string
    {
        return match ($method) {
            PaymentMethod::DINHEIRO => 'cash',
            PaymentMethod::PIX => 'pix',
            PaymentMethod::CARTAO_DEBITO => 'debit-card',
            PaymentMethod::CARTAO_CREDITO => 'credit-card',
        };
    }
}
