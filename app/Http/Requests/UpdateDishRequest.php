<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDishRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $dishId = $this->route('dish') ? $this->route('dish')->id : null;

        return [
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('dishes', 'name')->ignore($dishId),
            ],
            'description' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric|min:0|max:999999.99',
            'category_id' => 'sometimes|required|exists:categories,id',
            'image_url' => 'sometimes|nullable|string|url|max:2048',
            'ingredients' => 'sometimes|required|array|min:1',
            'ingredients.*' => 'required|string|max:100',
            'spice_level' => 'sometimes|required|string|in:Suave,Médio,Picante,Muito Picante',
            'is_available' => 'sometimes|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome do prato é obrigatório.',
            'name.unique' => 'Já existe um prato com este nome.',
            'name.max' => 'O nome do prato deve ter no máximo 255 caracteres.',
            'description.required' => 'A descrição do prato é obrigatória.',
            'price.required' => 'O preço do prato é obrigatório.',
            'price.numeric' => 'O preço deve ser um número válido.',
            'price.min' => 'O preço deve ser maior ou igual a zero.',
            'price.max' => 'O preço deve ser menor que R$ 999.999,99.',
            'category_id.required' => 'A categoria do prato é obrigatória.',
            'category_id.exists' => 'A categoria selecionada não existe.',
            'image_url.url' => 'A URL da imagem deve ser válida.',
            'image_url.max' => 'A URL da imagem deve ter no máximo 2048 caracteres.',
            'ingredients.required' => 'Os ingredientes são obrigatórios.',
            'ingredients.array' => 'Os ingredientes devem ser uma lista.',
            'ingredients.min' => 'Deve haver pelo menos 1 ingrediente.',
            'ingredients.*.required' => 'Cada ingrediente deve ser informado.',
            'ingredients.*.string' => 'Cada ingrediente deve ser um texto.',
            'ingredients.*.max' => 'Cada ingrediente deve ter no máximo 100 caracteres.',
            'spice_level.required' => 'O nível de picância é obrigatório.',
            'spice_level.in' => 'O nível de picância deve ser: Suave, Médio, Picante ou Muito Picante.',
            'is_available.boolean' => 'A disponibilidade deve ser verdadeiro ou falso.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nome',
            'description' => 'descrição',
            'price' => 'preço',
            'category_id' => 'categoria',
            'image_url' => 'imagem',
            'ingredients' => 'ingredientes',
            'spice_level' => 'nível de picância',
            'is_available' => 'disponibilidade',
        ];
    }
}
