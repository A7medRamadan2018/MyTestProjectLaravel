<?php

namespace App\Repository;

use App\Http\Requests\OrderRequest\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Product;
use App\RepositoryInterface\IOrderRepository;
use App\Services\OrderServices\CreateOrderService;

class OrderRepository implements IOrderRepository
{
    protected $createOrderService;
    public function __construct(CreateOrderService $createOrderService)
    {
        $this->createOrderService = $createOrderService;
    }

    public function getAllOrders()
    {
        return Order::all();
    }
    public function getAllForUser($user)
    {
        return $user->orders()->get();
    }

    public function show(Order $order)
    {
        return $order;
    }

    public function create(array $requestData, int $userId)
    {
        $order = $this->createOrderService->createOrder($userId, $requestData);
        return $order;
    }

    public function update(Order $order, array $data): void
    {
        // TODO: Implement update() method.
    }

    public function delete(Order $order)
    {
        $order->delete();
    }
}
