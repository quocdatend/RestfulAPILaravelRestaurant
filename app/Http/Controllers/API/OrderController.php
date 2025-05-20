<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\OrderService;
use App\Services\OrderItemService;

class OrderController extends Controller
{
    protected $orderService;
    protected $orderItemService;
    protected $userService;

    public function __construct(OrderService $orderService, OrderItemService $orderItemService, UserService $userService)
    {
        $this->orderService = $orderService;
        $this->orderItemService = $orderItemService;
        $this->userService = $userService;
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

    public function getByOrderId($id)
    {
        $order = $this->orderService->getOrderById($id);
        return response()->json([
            'status' => 'true',
            'order' => $order
        ], 200);
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

    public function rejectOrder($orderId)
    {
        $order = $this->orderService->getOrderByOrderId($orderId);

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found'
            ], 404);
        }

        $this->orderService->updateOrder($order, [
            'status' => -2,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Order rejected successfully',
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

    public function confirmPayment($orderId, $userId)
    {
        $order = $this->orderService->getOrderByOrderId($orderId);

        $user = $this->userService->getUserById($userId);
        
        if(!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found'
            ], 404);
        }

        $this->orderService->updateOrder($order, [
            'status' => 2,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Payment confirmed successfully',
            'order' => $order
        ]);
    }

    public function statusCompleted($orderId)
    {
        $order = $this->orderService->getOrderByOrderId($orderId);

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found'
            ], 404);
        }

        $this->orderService->updateOrder($order, [
            'status' => 3,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Order marked as completed successfully',
            'order' => $order
        ]);
    }

    public function confirmOrder($orderId)
    {
        $order = $this->orderService->getOrderByOrderId($orderId);

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found'
            ], 404);
        }

        $this->orderService->updateOrder($order, [
            'status' => 4,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Order confirmed successfully',
            'order' => $order
        ]);
    }

    public function statusConfirmed($orderId)
    {
        $order = $this->orderService->getOrderByOrderId($orderId);

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found'
            ], 404);
        }

        $this->orderService->updateOrder($order, [
            'status' => 5,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Order marked as confirmed successfully',
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
