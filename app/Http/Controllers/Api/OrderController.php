<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest\StoreOrderRequest;
use App\Http\Requests\OrderRequest\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\RepositoryInterface\IOrderRepository;
use App\Traits\HttpResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\ResponseTrait;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    use HttpResponseTrait;
    protected $orderRepository;

    public function __construct(IOrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }
    public function index()
    {
        $user = Auth::guard('sanctum')->user();
        $orders = $this->orderRepository->getAllForUser($user);
        return $this->success(OrderResource::collection($orders->load('orderProducts')));
    }
    public function get_all_orders()
    {
        $orders = $this->orderRepository->getAllOrders();
        return $this->success($message = count($orders),  $data=OrderResource::collection($orders->load('orderProducts')));
    }
    public function store(StoreOrderRequest $request)
    {
        $valid_request = $request->validated();
        $order = $this->orderRepository->create($valid_request, auth()->guard('sanctum')->user()->id);
        if (!$order)
            return $this->failure('order cannot added !');
        return $this->successResponse('order added successful', $order);
    }
    public function update(UpdateOrderRequest $request, Order $order)
    {
        $this->authorize('update', $order);
        $valid_request = $request->validated();
        $order = $this->orderRepository->update($order, $valid_request);
        return response()->json([
            'message' => 'Order updated successfully!',
            'order_id' => $order->id
        ], 201);
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);
        return new OrderResource($this->orderRepository->show($order));
    }
    public function destroy(Order $order)
    {
        $this->authorize('delete', $order);
        $this->orderRepository->delete($order);
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

    public function add_items_to_order(StoreOrderRequest $request, Order $order)
    {
        $valid_request = $request->validated();
        foreach ($valid_request as $order_item) {
            $product = Product::find($order_item['product_id']);
            if (!$product || $product->quantity < $order_item['quantity']) {
                return response()->json([
                    'message' => 'Insufficient stock for product ID: ' . $order_item['product_id']
                ], 400);
            }
            $product->decrement('quantity', $order_item['quantity']);
            $order->orderProducts()->create($order_item);
        }
        return response()->json([
            'message' => 'Order created successfully!',
            'order_id' => $order->id
        ], 201);
    }
}
