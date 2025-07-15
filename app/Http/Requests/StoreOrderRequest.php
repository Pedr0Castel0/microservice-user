<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'payment_method' => 'required|string|in:dinheiro,pix,cartao_debito,cartao_credito',
            'delivery_address' => 'required|array',
            'delivery_address.street' => 'required|string|max:255',
            'delivery_address.number' => 'required|string|max:10',
            'delivery_address.complement' => 'nullable|string|max:100',
            'delivery_address.neighborhood' => 'required|string|max:100',
            'delivery_address.city' => 'required|string|max:100',
            'delivery_address.state' => 'required|string|max:2',
            'delivery_address.zip_code' => 'required|string|max:10',
            'observations' => 'nullable|string|max:500',
            'items' => 'required|array|min:1',
            'items.*.dish_id' => 'required|exists:dishes,id',
            'items.*.quantity' => 'required|integer|min:1|max:99',
            'items.*.special_instructions' => 'nullable|string|max:200'
        ];
    }

    public function messages(): array
    {
        return [
            'payment_method.required' => 'O método de pagamento é obrigatório.',
            'payment_method.in' => 'Método de pagamento inválido. Opções: dinheiro, pix, cartao_debito, cartao_credito.',
            'delivery_address.required' => 'O endereço de entrega é obrigatório.',
            'delivery_address.array' => 'O endereço de entrega deve ser um objeto.',
            'delivery_address.street.required' => 'A rua é obrigatória.',
            'delivery_address.street.max' => 'A rua deve ter no máximo 255 caracteres.',
            'delivery_address.number.required' => 'O número é obrigatório.',
            'delivery_address.number.max' => 'O número deve ter no máximo 10 caracteres.',
            'delivery_address.complement.max' => 'O complemento deve ter no máximo 100 caracteres.',
            'delivery_address.neighborhood.required' => 'O bairro é obrigatório.',
            'delivery_address.neighborhood.max' => 'O bairro deve ter no máximo 100 caracteres.',
            'delivery_address.city.required' => 'A cidade é obrigatória.',
            'delivery_address.city.max' => 'A cidade deve ter no máximo 100 caracteres.',
            'delivery_address.state.required' => 'O estado é obrigatório.',
            'delivery_address.state.max' => 'O estado deve ter no máximo 2 caracteres.',
            'delivery_address.zip_code.required' => 'O CEP é obrigatório.',
            'delivery_address.zip_code.max' => 'O CEP deve ter no máximo 10 caracteres.',
            'observations.max' => 'As observações devem ter no máximo 500 caracteres.',
            'items.required' => 'Os itens do pedido são obrigatórios.',
            'items.array' => 'Os itens devem ser uma lista.',
            'items.min' => 'Deve haver pelo menos 1 item no pedido.',
            'items.*.dish_id.required' => 'O prato é obrigatório.',
            'items.*.dish_id.exists' => 'O prato selecionado não existe.',
            'items.*.quantity.required' => 'A quantidade é obrigatória.',
            'items.*.quantity.integer' => 'A quantidade deve ser um número inteiro.',
            'items.*.quantity.min' => 'A quantidade deve ser pelo menos 1.',
            'items.*.quantity.max' => 'A quantidade deve ser no máximo 99.',
            'items.*.special_instructions.max' => 'As instruções especiais devem ter no máximo 200 caracteres.'
        ];
    }

    public function attributes(): array
    {
        return [
            'payment_method' => 'método de pagamento',
            'delivery_address' => 'endereço de entrega',
            'observations' => 'observações',
            'items' => 'itens'
        ];
    }
}
