<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Services\OrderItemService;

class OrderController extends Controller
{
    protected $orderService;
    protected $orderItemService;

    public function __construct(OrderService $orderService, OrderItemService $orderItemService)
    {
        $this->orderService = $orderService;
        $this->orderItemService = $orderItemService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = $this->orderService->getAllOrders();
        if ($orders->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No orders found'
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'orders' => $orders
        ]);
    }

    /**
     * Display a listing of the resource by user.
     */
    public function indexByUser(Request $request)
    {
        $userId = $request->user()->id;
        $orders = $this->orderService->getOrdersByUserId($userId);
        if ($orders->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No orders found for this user'
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'orders' => $orders
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(OrderRequest $request)
    {
        $validatedData = $request->validated();
        $order = $this->orderService->createOrder([
            'order_id' => uniqid(),
            'user_id' => $request->user()->id,
            'total_price' => 0,
            'num_people' => $validatedData['num_people'],
            'special_request_id' => $validatedData['special_request_id'],
            'customer_name' => $validatedData['customer_name'],
            'order_date' => $validatedData['order_date'],
            'order_time' => $validatedData['order_time'],
            'party_id' => $validatedData['party_id'],
            'phone_number' => $validatedData['phone_number'],
            'status' => 0,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Order and Order Item created successfully',
            'order' => $order,
            // 'order_items' => $orderItems
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrderRequest $request, $id)
    {
        $validatedData = $request->validated();

        $order = $this->orderService->getOrderById($id);

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found'
            ], 404);
        }

        $this->orderService->updateOrder($order, [
            'user_id' => $validatedData['user_id'],
            'total_price' => 0,
            'num_people' => $validatedData['num_people'],
            'special_request_id' => $validatedData['special_request_id'],
            'customer_name' => $validatedData['customer_name'],
            'order_date' => $validatedData['order_date'],
            'order_time' => $validatedData['order_time'],
            'party_id' => $validatedData['party_id'],
            'phone_number' => $validatedData['phone_number'],
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Order updated successfully',
            'order' => $order
        ]);
    }

    /**
     * update price
     */
    public function updatePrice(Request $request, $id)
    {
        $validatedData = $request->validate([
            'total_price' => 'required|numeric|min:0',
        ]);

        $order = $this->orderService->getOrderById($id);

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found'
            ], 404);
        }

        $this->orderService->updateOrder($order, [
            'total_price' => $validatedData['total_price'],
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Order price updated successfully',
            'order' => $order
        ]);
    }

    /**
     * update status order complete
     */
    public function updateStatus($id)
    {
        $order = $this->orderService->getOrderById($id);

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found'
            ], 404);
        }

        $this->orderService->updateOrder($order, [
            'status' => 1,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Order status updated successfully',
            'order' => $order
        ]);
    }

    /**
     * update status order cancel
     */
    public function updateStatusCancel($id)
    {
        $order = $this->orderService->getOrderById($id);

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found'
            ], 404);
        }

        $this->orderService->updateOrder($order, [
            'status' => -1,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Order status updated successfully',
            'order' => $order
        ]);
    }
    
    // cancel or by user
    public function cancelOrder($orderId)
    {
        $order = $this->orderService->getOrderByOrderId($orderId);

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found'
            ], 404);
        }

        $this->orderService->updateOrder($order, [
            'status' => -1,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Order cancelled successfully',
            'order' => $order
        ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $order = $this->orderService->getOrderById($id);
        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found'
            ], 404);
        }

        $this->orderService->deleteOrder($order);

        return response()->json([
            'status' => 'success',
            'message' => 'Order deleted successfully'
        ]);
    }
}
