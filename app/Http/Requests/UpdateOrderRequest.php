<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => 'sometimes|string|in:confirmado,em_preparo,saiu_entrega,entregue',
            'payment_status' => 'sometimes|string|in:pendente,pago',
            'observations' => 'sometimes|nullable|string|max:500'
        ];
    }

    public function messages(): array
    {
        return [
            'status.in' => 'Status inválido. Opções: confirmado, em_preparo, saiu_entrega, entregue.',
            'payment_status.in' => 'Status de pagamento inválido. Opções: pendente, pago.',
            'observations.max' => 'As observações devem ter no máximo 500 caracteres.'
        ];
    }

    public function attributes(): array
    {
        return [
            'status' => 'status',
            'payment_status' => 'status de pagamento',
            'observations' => 'observações'
        ];
    }
}
