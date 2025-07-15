<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Http\Traits\ResponseTrait;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrderController extends Controller
{
    use ResponseTrait;

    public function __construct(private OrderService $orderService)
    {
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $orders = $this->orderService->getUserOrders($request->user()->id);

        return OrderResource::collection($orders);
    }

    public function store(StoreOrderRequest $request): JsonResponse
    {
        try {
            $order = $this->orderService->createOrder(
                $request->validated(),
                $request->user()->id
            );

            return $this->success(
                'Pedido criado com sucesso',
                new OrderResource($order),
                201
            );
        } catch (\Exception $e) {
            return $this->error('Erro ao criar pedido: ' . $e->getMessage(), 500);
        }
    }

    public function show(string $id, Request $request): JsonResponse
    {
        try {
            $order = $this->orderService->getOrderById($id, $request->user()->id);

            return $this->success(
                'Pedido encontrado',
                new OrderResource($order)
            );
        } catch (\Exception $e) {
            return $this->error('Pedido não encontrado', 404);
        }
    }

    public function update(UpdateOrderRequest $request, string $id): JsonResponse
    {
        try {
            $order = $this->orderService->getOrderById($id, $request->user()->id);

            $this->orderService->updateOrder($order, $request->validated());

            return $this->success(
                'Pedido atualizado com sucesso',
                new OrderResource($order->fresh())
            );
        } catch (\Exception $e) {
            return $this->error('Erro ao atualizar pedido: ' . $e->getMessage(), 500);
        }
    }

    public function destroy(string $id, Request $request): JsonResponse
    {
        try {
            $order = $this->orderService->getOrderById($id, $request->user()->id);

            if ($order->status !== 'confirmado') {
                return $this->error('Não é possível cancelar pedidos que já estão sendo preparados', 400);
            }

            $order->update(['status' => 'cancelado']);

            return $this->success('Pedido cancelado com sucesso');
        } catch (\Exception $e) {
            return $this->error('Erro ao cancelar pedido: ' . $e->getMessage(), 500);
        }
    }

    public function updateStatus(Request $request, string $id): JsonResponse
    {
        $request->validate([
            'status' => 'required|string|in:confirmado,em_preparo,saiu_entrega,entregue'
        ]);

        try {
            $order = Order::findOrFail($id);

            $this->orderService->updateOrderStatus($order, $request->status);

            return $this->success(
                'Status do pedido atualizado com sucesso',
                new OrderResource($order->fresh())
            );
        } catch (\Exception $e) {
            return $this->error('Erro ao atualizar status do pedido: ' . $e->getMessage(), 500);
        }
    }

    public function updatePaymentStatus(Request $request, string $id): JsonResponse
    {
        $request->validate([
            'payment_status' => 'required|string|in:pendente,pago'
        ]);

        try {
            $order = Order::findOrFail($id);

            $this->orderService->updatePaymentStatus($order, $request->payment_status);

            return $this->success(
                'Status de pagamento atualizado com sucesso',
                new OrderResource($order->fresh())
            );
        } catch (\Exception $e) {
            return $this->error('Erro ao atualizar status de pagamento: ' . $e->getMessage(), 500);
        }
    }
}
