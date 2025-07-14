<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Traits\ResponseTrait;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    use ResponseTrait;

    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(): JsonResponse
    {
        try {
            $categories = $this->categoryService->getAllCategories();

            return $this->successResponse(
                'Categorias obtidas com sucesso',
                CategoryResource::collection($categories)
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Erro ao obter categorias',
                $e->getMessage()
            );
        }
    }

    public function store(StoreCategoryRequest $request): JsonResponse
    {
        try {
            $category = $this->categoryService->createCategory($request->validated());

            return $this->successResponse(
                'Categoria criada com sucesso',
                new CategoryResource($category),
                Response::HTTP_CREATED
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Erro ao criar categoria',
                $e->getMessage()
            );
        }
    }

    public function show(Category $category): JsonResponse
    {
        try {
            $category = $this->categoryService->getCategoryById($category->id);

            if (!$category) {
                return $this->errorResponse(
                    'Categoria não encontrada',
                    null,
                    Response::HTTP_NOT_FOUND
                );
            }

            return $this->successResponse(
                'Categoria obtida com sucesso',
                new CategoryResource($category)
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Erro ao obter categoria',
                $e->getMessage()
            );
        }
    }

    public function update(UpdateCategoryRequest $request, Category $category): JsonResponse
    {
        try {
            $updated = $this->categoryService->updateCategory($category, $request->validated());

            if (!$updated) {
                return $this->errorResponse(
                    'Erro ao atualizar categoria',
                    null,
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }

            return $this->successResponse(
                'Categoria atualizada com sucesso',
                new CategoryResource($category->fresh())
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Erro ao atualizar categoria',
                $e->getMessage()
            );
        }
    }

    public function destroy(Category $category): JsonResponse
    {
        try {
            $deleted = $this->categoryService->deleteCategory($category);

            if (!$deleted) {
                return $this->errorResponse(
                    'Erro ao excluir categoria',
                    null,
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }

            return $this->successResponse(
                'Categoria excluída com sucesso'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Erro ao excluir categoria',
                $e->getMessage()
            );
        }
    }
}
