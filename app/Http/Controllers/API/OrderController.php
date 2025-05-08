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
     * Show the form for creating a new resource.
     */
    public function create(OrderRequest $request)
    {
        $validatedData = $request->validated();

        $order = $this->orderService->createOrder([
            'id' => uniqid(),
            'user_id' => $validatedData['user_id'],
            'total_price' => $validatedData['total_price'],
            'num_people' => $validatedData['num_people'],
            'special_request' => $validatedData['special_request'],
            'customer_name' => $validatedData['customer_name'],
            'order_date' => $validatedData['order_date'],
            'order_time' => $validatedData['order_time'],
            'style_tiec' => $validatedData['style_tiec'],
            'phone_number' => $validatedData['phone_number'],
        ]);

        $orderItems = $this->orderItemService->createOrderItem([
            'id' => uniqid(),
            'order_id' => $validatedData['order_id'],
            'menu_id' => $validatedData['menu_id'],
            'quantity' => $validatedData['quantity'],
            'status' => 0,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Order and Order Item created successfully',
            'order' => $order,
            'order_items' => $orderItems
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
            'total_price' => $validatedData['total_price'],
            'num_people' => $validatedData['num_people'],
            'special_request' => $validatedData['special_request'],
            'customer_name' => $validatedData['customer_name'],
            'order_date' => $validatedData['order_date'],
            'order_time' => $validatedData['order_time'],
            'style_tiec' => $validatedData['style_tiec'],
            'phone_number' => $validatedData['phone_number'],
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Order updated successfully',
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
