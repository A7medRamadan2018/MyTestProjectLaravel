<?php

namespace App\Services\OrderServices;

use App\Models\Order;
use App\Models\Product;

class CreateOrderService
{
    public function createOrder(int $userId, array $orderItems)
    {
        $order = Order::create(['user_id' => $userId]);
        $this->processItems($orderItems,$order);
        return $order;
    }
    protected function processItems(array $orderItems,Order $order)
    {
        foreach ($orderItems as $orderItem) {
            $product = $this->findProduct($orderItem['product_id']);
            $this->checkProductQuantity($product,  $orderItem['quantity']);
            $this->updateProductQuantity($product, $orderItem['quantity']);
            $this->assignOrderItemToOrder($order, $orderItem);
        }
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
}
