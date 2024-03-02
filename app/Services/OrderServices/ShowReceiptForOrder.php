<?php

namespace App\Services\OrderServices;

use App\Models\Order;
use App\Models\Product;


class ShowReceiptForOrder
{
    public function __construct()
    {
    }

    public function calculateRecieptTotalCost(Order $order)
    {
        $product_for_orders = $order->orderProducts()->get();
        $total_cost = 0;
        foreach ($product_for_orders as $product_order) {
            $product = Product::find($product_order->product_id);
            $total_cost +=  $product_order->quantity * $product->price;
        }
        return $total_cost;
    }
}
