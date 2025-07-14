<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CategoryService
{
    public function getAllCategories(): Collection
    {
        return Category::with('dishes')->get();
    }

    public function getCategoryById(int $id): ?Model
    {
        return Category::with('dishes')->find($id);
    }

    public function createCategory(array $data): Category
    {
        return Category::create($data);
    }

    public function updateCategory(Category $category, array $data): bool
    {
        return $category->update($data);
    }

    public function deleteCategory(Category $category): bool
    {
        return $category->delete();
    }

    public function getCategoriesWithDishCount(): Collection
    {
        return Category::withCount('dishes')->get();
    }
}
