<?php

namespace App\Services\OrderServices;

use App\Models\Order;
use App\Models\Product;
use App\Services\OrderServices\OrderSeviceHelperFunctions;

class CreateOrderService
{
    public function __construct(public OrderSeviceHelperFunctions $orderSeviceHelperFunctions)
    {
    }
    public function createOrder(int $userId, array $orderItems)
    {
        $order = Order::create(['user_id' => $userId]);
        $this->processItems($orderItems, $order);
        return $order;
    }

    protected function processItems(array $orderItems, Order $order)
    {
        foreach ($orderItems as $orderItem) {
            $product = $this->orderSeviceHelperFunctions->findProduct($orderItem['product_id']);
            $this->orderSeviceHelperFunctions->checkProductQuantity($product,  $orderItem['quantity']);
            $this->orderSeviceHelperFunctions->updateProductQuantity($product, $orderItem['quantity']);
            $this->orderSeviceHelperFunctions->assignOrderItemToOrder($order, $orderItem);
        }
    }
}
