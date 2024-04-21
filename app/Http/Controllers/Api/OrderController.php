<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest\StoreOrderRequest;
use App\Http\Requests\OrderRequest\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\RepositoryInterface\IOrderRepository;
use App\Services\OrderServices\ShowReceiptForOrder;
use App\Services\OrderServices\UpdateOrderService;
use App\Traits\HttpResponseTrait;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    use HttpResponseTrait;
    public function __construct(
        public IOrderRepository $orderRepository,
        public ShowReceiptForOrder $showReceipt,
        public UpdateOrderService $updateOrderService
    ) {
    }
    public function index()
    {
        $user = Auth::guard('user')->user();
        $orders = $this->orderRepository->getAllForUser($user);
        return $this->success(OrderResource::collection($orders->load('orderItems')));
    }
    public function allOrders()
    {
        $orders = $this->orderRepository->getAllOrders();
        return $this->success(
            $message = count($orders),
            $data = OrderResource::collection($orders->load('orderItems'))
        );
    }
    public function store(StoreOrderRequest $request)
    {
        $valid_request = $request->validated();
        $order = $this->orderRepository->create($valid_request, auth()->guard('user')->user()->id);
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
        $this->authorize('view', $order);
        $total_cost = $this->showReceipt->calculateRecieptTotalCost($order);
        return response()->json(
            [
                'order_id' => $order->id,
                'total_Cost' => $total_cost,
                'time_created' => $order->created_at
            ]
        );
    }

    public function addItemsToOrder(StoreOrderRequest $request, Order $order)
    {
        $this->authorize('update', $order);
        $valid_request = $request->validated();
        $order = $this->updateOrderService->addItemsToOrder($order, $valid_request);
        return response()->json([
            'message' => 'Order created successfully!',
            'order_id' => $order->id
        ], 201);
    }
}
