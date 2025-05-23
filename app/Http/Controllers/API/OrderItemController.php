<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderItemRequest;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Services\OrderItemService;

use function Laravel\Prompts\confirm;

class OrderItemController extends Controller
{
    protected $orderItemService;

    public function __construct(OrderItemService $orderItemService)
    {
        $this->orderItemService = $orderItemService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orderItems = $this->orderItemService->getAllOrderItems();
        return response()->json([
            'status' => 'success',
            'order_items' => $orderItems
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(OrderItemRequest $request)
    {
        $validated = $request->validated();

        $orderItem = $this->orderItemService->createOrderItem([
            'id' => str_pad(mt_rand(0, 9999999999999), 13, '0', STR_PAD_RIGHT),
            'order_id' => $validated['order_id'],
            'menu_id' => $validated['menu_id'],
            'quantity' => $validated['quantity'],
            'price' => $validated['price'],
            'total_price' => $validated['total_price']
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Order item created successfully',
            'order_item' => $orderItem
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
     * find by order id
     */
    public function findByOrder($orderId)
    {
        $orderItems = $this->orderItemService->getOrderItemsByOrderId($orderId);
        if ($orderItems->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'order_items' => $orderItems
            ], 200);
        }
        return response()->json([
            'status' => 'success',
            'order_items' => $orderItems
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderItem $orderItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderItem $orderItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrderItemRequest $request, $id)
    {
        $validated = $request->validated();

        $orderItem = $this->orderItemService->getOrderItemById($id);
        if (!$orderItem) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order item not found'
            ], 404);
        }
        $this->orderItemService->updateOrderItem($orderItem,[
            'order_id' => $validated['order_id'],
            'menu_id' => $validated['menu_id'],
            'quantity' => $validated['quantity'],
            'price' => $validated['price'],
            'total_price' => $validated['total_price']
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Order item updated successfully',
            'order_item' => $orderItem
        ]);
    }

    /**
     * update status of order item
     */
    public function updateStatus($id)
    {
        $orderItem = $this->orderItemService->getOrderItemById($id);
        if (!$orderItem) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order item not found'
            ], 404);
        }

        $this->orderItemService->updateOrderItem($orderItem, [
            'status' => $orderItem->status == 1
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Order item status updated successfully',
            'order_item' => $orderItem
        ]);
    }

    /**
     * Cancel order item
     */
    public function cancelOrderItem($id)
    {
        $orderItem = $this->orderItemService->getOrderItemById($id);
        if (!$orderItem) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order item not found'
            ], 404);
        }
        $this->orderItemService->updateOrderItem($orderItem, [
            'status' => -1
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Order item cancelled successfully',
            'order_item' => $orderItem
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $orderItem = $this->orderItemService->getOrderItemById($id);
        if (!$orderItem) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order item not found'
            ], 404);
        }
        $this->orderItemService->deleteOrderItem($orderItem);

        return response()->json([
            'status' => 'success',
            'message' => 'Order item deleted successfully'
        ]);
    }
}
