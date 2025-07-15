<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DishResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => [
                'value' => $this->price,
                'formatted' => 'R$ ' . number_format($this->price, 2, ',', '.'),
            ],
            'category' => [
                'id' => $this->category->id,
                'name' => $this->category->name,
                'description' => $this->category->description,
            ],
            'image_url' => $this->image_url,
            'ingredients' => $this->ingredients,
            'spice_level' => [
                'level' => $this->spice_level,
                'description' => $this->getSpiceLevelDescription(),
                'emoji' => $this->getSpiceLevelEmoji(),
            ],
            'is_available' => $this->is_available,
            'availability_status' => $this->is_available ? 'Disponível' : 'Indisponível',
            'created_at' => $this->created_at->format('d/m/Y H:i:s'),
            'updated_at' => $this->updated_at->format('d/m/Y H:i:s'),
        ];
    }

    private function getSpiceLevelDescription(): string
    {
        return match ($this->spice_level) {
            'Suave' => 'Ideal para quem não gosta de comida picante',
            'Médio' => 'Um toque de picância equilibrado',
            'Picante' => 'Para quem gosta de comida bem temperada',
            'Muito Picante' => 'Extremamente picante, apenas para corajosos!',
            default => 'Nível de picância não definido',
        };
    }

    private function getSpiceLevelEmoji(): string
    {
        return match ($this->spice_level) {
            'Suave' => '🟢',
            'Médio' => '🟡',
            'Picante' => '🟠',
            'Muito Picante' => '🔴',
            default => '⚪',
        };
    }
}
