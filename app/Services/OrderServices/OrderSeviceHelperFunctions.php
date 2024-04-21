<?php

namespace App\Services\OrderServices;

use App\Models\Order;
use App\Models\OrderItems;
use App\Models\OrderProduct;
use App\Models\Product;

class  OrderSeviceHelperFunctions
{
    public function checkProductQuantity(Product $product, $quantity)
    {
        if (!$product || $product->quantity < $quantity) {
            throw new \RuntimeException('Insufficient stock for product ID: ' . $quantity);
        }
    }
    public function findProduct(int $productId): ?Product
    {
        return Product::find($productId);
    }

    public function updateProductQuantity(Product $product, int $quantity): void
    {
        $product->decrement('quantity', $quantity);
    }

    public function assignOrderItemToOrder(Order $order, array $orderItem): void
    {
        $order->orderItems()->create($orderItem);
    }
    public function decrementProductQuantity(Product $product, int $quantity): void
    {
        $product->decrement('quantity', $quantity);
    }

    public function updateOrderItem(OrderItems  $order_product, array $orderItems): void
    {
        $order_product->update($orderItems);
    }
}
