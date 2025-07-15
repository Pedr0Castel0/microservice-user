<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDishRequest;
use App\Http\Requests\UpdateDishRequest;
use App\Http\Resources\DishResource;
use App\Http\Traits\ResponseTrait;
use App\Models\Dish;
use App\Services\DishService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class DishController extends Controller
{
    use ResponseTrait;

    public function __construct(private DishService $dishService)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $filters = $request->only([
            'search',
            'category_id',
            'spice_level',
            'ingredient',
            'min_price',
            'max_price',
            'available',
            'sort'
        ]);

        $perPage = $request->input('per_page', 15);
        $dishes = $this->dishService->getAll($filters, $perPage);

        return $this->successResponse(
            'Pratos listados com sucesso',
            DishResource::collection($dishes)->response()->getData(true)
        );
    }

    public function show(int $id): JsonResponse
    {
        try {
            $dish = Dish::with('category')->findOrFail($id);
            return $this->successResponse(
                'Prato encontrado com sucesso',
                new DishResource($dish)
            );
        } catch (\Exception $e) {
            return $this->errorResponse('Prato não encontrado', null, 404);
        }
    }

    public function store(StoreDishRequest $request): JsonResponse
    {
        try {
            $dish = Dish::create($request->validated());
            $dish->load('category');

            return $this->successResponse(
                'Prato criado com sucesso',
                new DishResource($dish),
                201
            );
        } catch (\Exception $e) {
            return $this->errorResponse('Erro ao criar prato: ' . $e->getMessage(), null, 500);
        }
    }

    public function update(UpdateDishRequest $request, int $id): JsonResponse
    {
        try {
            $dish = Dish::findOrFail($id);
            $dish->update($request->validated());
            $dish->load('category');

            return $this->successResponse(
                'Prato atualizado com sucesso',
                new DishResource($dish)
            );
        } catch (\Exception $e) {
            return $this->errorResponse('Erro ao atualizar prato: ' . $e->getMessage(), null, 500);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $dish = Dish::findOrFail($id);
            $dish->delete();

            return $this->successResponse(
                'Prato removido com sucesso'
            );
        } catch (\Exception $e) {
            return $this->errorResponse('Erro ao remover prato: ' . $e->getMessage(), null, 500);
        }
    }

    public function available(Request $request): JsonResponse
    {
        $filters = $request->only([
            'search',
            'category_id',
            'spice_level',
            'ingredient',
            'min_price',
            'max_price',
            'sort'
        ]);

        $perPage = $request->input('per_page', 15);
        $dishes = $this->dishService->getAvailable($filters, $perPage);

        return $this->successResponse(
            'Pratos disponíveis listados com sucesso',
            DishResource::collection($dishes)->response()->getData(true)
        );
    }

    public function byCategory(Request $request, int $categoryId): JsonResponse
    {
        $filters = $request->only([
            'search',
            'spice_level',
            'ingredient',
            'min_price',
            'max_price',
            'available',
            'sort'
        ]);

        $perPage = $request->input('per_page', 15);
        $dishes = $this->dishService->getByCategory($categoryId, $filters, $perPage);

        return $this->successResponse(
            'Pratos da categoria listados com sucesso',
            DishResource::collection($dishes)->response()->getData(true)
        );
    }

    public function search(Request $request): JsonResponse
    {
        $search = $request->input('q', '');

        if (empty($search)) {
            return $this->errorResponse('Termo de busca é obrigatório', null, 400);
        }

        $filters = $request->only([
            'category_id',
            'spice_level',
            'ingredient',
            'min_price',
            'max_price',
            'available',
            'sort'
        ]);

        $perPage = $request->input('per_page', 15);
        $dishes = $this->dishService->search($search, $filters, $perPage);

        return $this->successResponse(
            'Resultados da busca por: ' . $search,
            DishResource::collection($dishes)->response()->getData(true)
        );
    }

    public function bySpiceLevel(Request $request, string $spiceLevel): JsonResponse
    {
        $validLevels = ['Suave', 'Médio', 'Picante', 'Muito Picante'];

        if (!in_array($spiceLevel, $validLevels)) {
            return $this->errorResponse('Nível de picância inválido', null, 400);
        }

        $filters = $request->only([
            'search',
            'category_id',
            'ingredient',
            'min_price',
            'max_price',
            'available',
            'sort'
        ]);

        $perPage = $request->input('per_page', 15);
        $dishes = $this->dishService->getBySpiceLevel($spiceLevel, $filters, $perPage);

        return $this->successResponse(
            'Pratos com nível de picância: ' . $spiceLevel,
            DishResource::collection($dishes)->response()->getData(true)
        );
    }



    public function byPriceRange(Request $request): JsonResponse
    {
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        if (!$minPrice || !$maxPrice) {
            return $this->errorResponse('Preço mínimo e máximo são obrigatórios', null, 400);
        }

        if ($minPrice > $maxPrice) {
            return $this->errorResponse('Preço mínimo não pode ser maior que o preço máximo', null, 400);
        }

        $filters = $request->only([
            'search',
            'category_id',
            'spice_level',
            'ingredient',
            'available',
            'sort'
        ]);

        $perPage = $request->input('per_page', 15);
        $dishes = $this->dishService->getByPriceRange($minPrice, $maxPrice, $filters, $perPage);

        return $this->successResponse(
            'Pratos entre R$ ' . number_format($minPrice, 2, ',', '.') . ' e R$ ' . number_format($maxPrice, 2, ',', '.'),
            DishResource::collection($dishes)->response()->getData(true)
        );
    }

    public function featured(Request $request): JsonResponse
    {
        $limit = $request->input('limit', 6);
        $dishes = $this->dishService->getFeatured($limit);

        return $this->successResponse(
            'Pratos em destaque',
            DishResource::collection($dishes)
        );
    }

    public function popular(Request $request): JsonResponse
    {
        $limit = $request->input('limit', 10);
        $dishes = $this->dishService->getPopular($limit);

        return $this->successResponse(
            'Pratos populares',
            DishResource::collection($dishes)
        );
    }

    public function recommendations(Request $request, int $dishId): JsonResponse
    {
        try {
            $limit = $request->input('limit', 4);
            $recommendations = $this->dishService->getRecommendations($dishId, $limit);

            return $this->successResponse(
                'Recomendações baseadas no prato',
                DishResource::collection($recommendations)
            );
        } catch (\Exception $e) {
            return $this->errorResponse('Prato não encontrado para recomendações', null, 404);
        }
    }

    public function spiceLevels(): JsonResponse
    {
        $levels = $this->dishService->getSpiceLevels();

        return $this->successResponse(
            'Níveis de picância disponíveis',
            $levels
        );
    }

    public function statistics(): JsonResponse
    {
        $stats = $this->dishService->getStatistics();

        return $this->successResponse(
            'Estatísticas do cardápio',
            $stats
        );
    }

    public function toggleAvailability(int $id): JsonResponse
    {
        try {
            $dish = $this->dishService->toggleAvailability($id);
            $dish->load('category');

            return $this->successResponse(
                'Disponibilidade alterada com sucesso',
                new DishResource($dish)
            );
        } catch (\Exception $e) {
            return $this->errorResponse('Erro ao alterar disponibilidade: ' . $e->getMessage(), null, 500);
        }
    }
}
