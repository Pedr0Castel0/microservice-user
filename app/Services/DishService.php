<?php

namespace App\Services;

use App\Models\Dish;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class DishService
{
    public function getAll(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Dish::with('category');

        $query = $this->applyFilters($query, $filters);

        return $query->paginate($perPage);
    }

    public function getAvailable(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $filters['available'] = true;
        return $this->getAll($filters, $perPage);
    }

    public function getByCategory(int $categoryId, array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $filters['category_id'] = $categoryId;
        return $this->getAll($filters, $perPage);
    }

    public function search(string $term, array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $filters['search'] = $term;
        return $this->getAll($filters, $perPage);
    }

    public function getBySpiceLevel(string $spiceLevel, array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $filters['spice_level'] = $spiceLevel;
        return $this->getAll($filters, $perPage);
    }

    public function getByIngredient(string $ingredient, array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $filters['ingredient'] = $ingredient;
        return $this->getAll($filters, $perPage);
    }

    public function getByPriceRange(float $minPrice, float $maxPrice, array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $filters['min_price'] = $minPrice;
        $filters['max_price'] = $maxPrice;
        return $this->getAll($filters, $perPage);
    }

    public function getFeatured(int $limit = 6): Collection
    {
        return Dish::with('category')
            ->where('is_available', true)
            ->whereHas('category', function ($query) {
                $query->whereIn('name', ['Tacos', 'Burritos', 'Nachos']);
            })
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }

    public function getPopular(int $limit = 10): Collection
    {
        return Dish::with('category')
            ->where('is_available', true)
            ->whereIn('name', [
                'Taco al Pastor',
                'Burrito de Carnitas',
                'Quesadilla de Pollo',
                'Nachos Supreme',
                'Taco de Pollo',
                'Burrito de Pollo',
                'Margarita',
                'Água de Horchata'
            ])
            ->get();
    }

    public function getRecommendations(int $dishId, int $limit = 4): Collection
    {
        $dish = Dish::findOrFail($dishId);

        return Dish::with('category')
            ->where('is_available', true)
            ->where('id', '!=', $dishId)
            ->where(function ($query) use ($dish) {
                $query->where('category_id', $dish->category_id)
                      ->orWhere('spice_level', $dish->spice_level);
            })
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }

    public function getSpiceLevels(): array
    {
        return [
            'Suave' => [
                'level' => 'Suave',
                'description' => 'Ideal para quem não gosta de comida picante',
                'emoji' => '🟢',
                'count' => Dish::where('spice_level', 'Suave')->where('is_available', true)->count()
            ],
            'Médio' => [
                'level' => 'Médio',
                'description' => 'Um toque de picância equilibrado',
                'emoji' => '🟡',
                'count' => Dish::where('spice_level', 'Médio')->where('is_available', true)->count()
            ],
            'Picante' => [
                'level' => 'Picante',
                'description' => 'Para quem gosta de comida bem temperada',
                'emoji' => '🟠',
                'count' => Dish::where('spice_level', 'Picante')->where('is_available', true)->count()
            ],
            'Muito Picante' => [
                'level' => 'Muito Picante',
                'description' => 'Extremamente picante, apenas para corajosos!',
                'emoji' => '🔴',
                'count' => Dish::where('spice_level', 'Muito Picante')->where('is_available', true)->count()
            ]
        ];
    }

    public function toggleAvailability(int $dishId): Dish
    {
        $dish = Dish::findOrFail($dishId);
        $dish->is_available = !$dish->is_available;
        $dish->save();

        return $dish;
    }

    public function getStatistics(): array
    {
        return [
            'total_dishes' => Dish::count(),
            'available_dishes' => Dish::where('is_available', true)->count(),
            'unavailable_dishes' => Dish::where('is_available', false)->count(),
            'categories_count' => Dish::distinct('category_id')->count(),
            'average_price' => Dish::where('is_available', true)->avg('price'),
            'price_range' => [
                'min' => Dish::where('is_available', true)->min('price'),
                'max' => Dish::where('is_available', true)->max('price')
            ],
            'spice_levels' => $this->getSpiceLevels()
        ];
    }

    private function applyFilters($query, array $filters)
    {
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (isset($filters['available'])) {
            $query->where('is_available', $filters['available']);
        }

        if (!empty($filters['spice_level'])) {
            $query->where('spice_level', $filters['spice_level']);
        }

        if (!empty($filters['ingredient'])) {
            $ingredient = $filters['ingredient'];
            $query->whereJsonContains('ingredients', $ingredient);
        }

        if (!empty($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }

        if (!empty($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }

        return $query;
    }

    private function applySorting($query, string $sort)
    {
        switch ($sort) {
            case 'name':
                return $query->orderBy('name', 'asc');
            case 'price_asc':
                return $query->orderBy('price', 'asc');
            case 'price_desc':
                return $query->orderBy('price', 'desc');
            case 'newest':
                return $query->orderBy('created_at', 'desc');
            case 'oldest':
                return $query->orderBy('created_at', 'asc');
            case 'category':
                return $query->join('categories', 'dishes.category_id', '=', 'categories.id')
                            ->orderBy('categories.name', 'asc')
                            ->orderBy('dishes.name', 'asc')
                            ->select('dishes.*');
            default:
                return $query->orderBy('name', 'asc');
        }
    }
}
