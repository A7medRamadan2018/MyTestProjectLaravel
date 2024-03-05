<?php

namespace App\Repository;

use App\Models\Order;
use App\RepositoryInterface\IOrderRepository;
use App\Services\OrderServices\CreateOrderService;
use App\Services\OrderServices\UpdateOrderService;

class OrderRepository implements IOrderRepository
{
    protected $createOrderService;
    protected $updateOrderService;

    public function __construct(CreateOrderService $createOrderService, UpdateOrderService $updateOrderService)
    {
        $this->createOrderService = $createOrderService;
        $this->updateOrderService = $updateOrderService;
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

    public function update(Order $order, array $data)
    {
        $order = $this->updateOrderService->updateOrder($order, $data);
        return $order;
    }

    public function delete(Order $order)
    {
        $order->delete();
    }
}
