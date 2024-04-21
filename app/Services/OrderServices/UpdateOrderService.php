<?php

namespace App\Services\OrderServices;

use App\Models\Order;
use App\Models\OrderItems;
use App\Models\OrderProduct;
use App\Services\OrderServices\OrderSeviceHelperFunctions;

class UpdateOrderService
{
    public function __construct(public OrderSeviceHelperFunctions $orderSeviceHelperFunctions)
    {
    }
    public function updateOrder(Order $order, array $orderItems)
    {
        $this->processItems($orderItems, $order);
        return $order;
    }
    protected function processItems(array $orderItems, Order $order)
    {
        foreach ($orderItems as $orderItem) {
            $product = $this->orderSeviceHelperFunctions->findProduct($orderItem['product_id']);
            $order_product = OrderItems::where('product_id', $product->id)->where('order_id', $order->id)->first();
            $product->increment('quantity', $order_product->quantity);
            $this->orderSeviceHelperFunctions->checkProductQuantity($product,  $orderItem['quantity']);
            $this->orderSeviceHelperFunctions->decrementProductQuantity($product, $orderItem['quantity']);
            $this->orderSeviceHelperFunctions->updateOrderItem($order_product, $orderItem);
        }
    }

    protected function addItems(array $orderItems, Order $order)
    {
        foreach ($orderItems as $orderItem) {
            $product = $this->orderSeviceHelperFunctions->findProduct($orderItem['product_id']);
            $this->orderSeviceHelperFunctions->checkProductQuantity($product,  $orderItem['quantity']);
            $this->orderSeviceHelperFunctions->decrementProductQuantity($product, $orderItem['quantity']);
            $this->orderSeviceHelperFunctions->assignOrderItemToOrder($order, $orderItem);
        }
    }

    public function addItemsToOrder(Order $order, array $orderItems)
    {
        $this->addItems($orderItems, $order);
        return $order;
    }
}
