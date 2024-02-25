<?php

namespace App\Repository;

use App\Http\Requests\OrderRequest\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Product;
use App\RepositoryInterface\IOrderRepository;

class OrderRepository implements IOrderRepository
{

    public function getAllForUser($user)
    {
        return $user->orders()->get();
    }

    public function show(Order $order)
    {
        // TODO: Implement show() method.
    }

    public function create(array $requestData, int $userId): Order
    {
        $order = $this->createOrder($userId);
        foreach ($requestData as $orderItem) {
            $this->processOrderItem($order, $orderItem);
        }
        return $order;
    }

    protected function createOrder(int $userId): Order
    {
        return Order::create(['user_id' => $userId]);
    }

    protected function processOrderItem(Order $order, array $orderItem)
    {
        $product = $this->findProduct($orderItem['product_id']);
        $this->checkProductQuantity($product,  $orderItem['quantity']);
        $this->updateProductQuantity($product, $orderItem['quantity']);
        $this->assignOrderItemToOrder($order, $orderItem);
    }

    protected function checkProductQuantity(Product $product, $quantity)
    {
        if (!$product || $product->quantity < $quantity) {
            throw new \RuntimeException('Insufficient stock for product ID: ' . $quantity);
        }
    }
    protected function findProduct(int $productId): ?Product
    {
        return Product::find($productId);
    }

    protected function updateProductQuantity(Product $product, int $quantity): void
    {
        $product->decrement('quantity', $quantity);
    }

    protected function assignOrderItemToOrder(Order $order, array $orderItem): void
    {
        $order->orderProducts()->create($orderItem);
    }

    public function update(Order $order, array $data): void
    {
        // TODO: Implement update() method.
    }

    public function delete(Order $order)
    {
        // TODO: Implement delete() method.
    }
}
