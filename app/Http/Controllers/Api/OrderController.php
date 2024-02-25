<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest\StoreOrderRequest;
use App\Http\Requests\OrderRequest\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $user = Auth::guard('sanctum')->user();
        $orders = $user->orders()->get();
        return  OrderResource::collection($orders->load('orderProducts'));
    }
    public function store(StoreOrderRequest $request)
    {
        $valid_request = $request->validated();
        $order = Order::create(['user_id' => auth()->guard('sanctum')->user()->id]);
        foreach ($valid_request as $order_item) {
            $product = Product::find($order_item['product_id']);
            if (!$product || $product->quantity < $order_item['quantity']) {
                return response()->json([
                    'message' => 'Insufficient stock for product ID: ' . $order_item['product_id']
                ], 400);
            }
            $product->decrement('quantity', $order_item['quantity']);
            $order_item['order_id'] = $order->id;
            OrderProduct::create($order_item);
        }
        return response()->json([
            'message' => 'Order created successfully!',
            'order_id' => $order->id
        ], 201);
    }
    public function update(UpdateOrderRequest $request, Order $order)
    {
        $this->authorize('update', $order);
        $valid_request = $request->validated();
        foreach ($valid_request as $order_item) {
            $product = Product::find($order_item['product_id']);
            $order_product = OrderProduct::where('product_id', $product->id)->first();
            if (!$product || $product->quantity < $order_item['quantity']) {
                return response()->json([
                    'message' => 'Insufficient stock for product ID: ' . $order_item['product_id']
                ], 400);
            }
            $product->increment('quantity', $order_product->quantity);
            $product->decrement('quantity', $order_item['quantity']);
            $order_product->update($order_item);
        }
        return response()->json([
            'message' => 'Order updated successfully!',
            'order_id' => $order->id
        ], 201);
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);
        return new OrderResource($order);
    }
    public function destroy(Order $order)
    {
        $this->authorize('delete', $order);
        $order->delete();
        return response()->json([
            'message' => 'Order deleted successfully!',
            'order_id' => $order->id
        ], 201);
    }

    public function showReceipt(Order $order)
    {
        // Calculate the total cost
        $product_for_orders = $order->orderProducts()->get();
        $total_cost = 0;
        foreach ($product_for_orders as $product_order) {
            $product = Product::find($product_order->product_id);
            $total_cost +=  $product_order->quantity * $product->price;
        }
        return response()->json(
            [
                'order_id' => $order->id,
                'total_Cost' => $total_cost,
                'time_created' => $order->created_at
            ]
        );
    }
}
