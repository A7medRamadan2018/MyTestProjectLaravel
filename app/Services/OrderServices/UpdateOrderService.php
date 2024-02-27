<?php

namespace App\Services\OrderServices;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;

class UpdateOrderService
{
    public function updateOrder(Order $order, array $orderItems)
    {
        $this->processItems($orderItems, $order);
        return $order;
    }
    protected function processItems(array $orderItems, Order $order)
    {
        foreach ($orderItems as $orderItem) {
            $product = $this->findProduct($orderItem['product_id']);
            $order_product = OrderProduct::where('product_id', $product->id)->first();
            $product->increment('quantity', $order_product->quantity);
            $this->checkProductQuantity($product,  $orderItem['quantity']);
            $this->decrementProductQuantity($product, $orderItem['quantity']);
            $this->updateOrderItem($order_product, $orderItem);
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

    protected function decrementProductQuantity(Product $product, int $quantity): void
    {
        $product->decrement('quantity', $quantity);
    }

    protected function updateOrderItem(OrderProduct  $order_product, array $orderItems): void
    {
        $order_product->update($orderItems);
    }
}
