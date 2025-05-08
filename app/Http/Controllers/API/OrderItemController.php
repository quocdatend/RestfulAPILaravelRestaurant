<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderItemRequest;
use App\Models\OrderItem;
use Illuminate\Http\Request;

use function Laravel\Prompts\confirm;

class OrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orderItems = OrderItem::all();
        return response()->json([
            'status' => 'success',
            'order_items' => $orderItems
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // $request->validate([
        //     'order_id' => 'required|exists:orders,id',
        //     'menu_id' => 'required|exists:menus,id',
        //     'quantity' => 'required|integer|min:1',
        // ]);

        // $orderItem = OrderItem::create([
        //     'id' => uniqid(),
        //     'order_id' => $request->order_id,
        //     'menu_id' => $request->menu_id,
        //     'quantity' => $request->quantity,
        //     'status' => 0,
        // ]);

        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'Order item created successfully',
        //     'order_item' => $orderItem
        // ]);
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
        $orderItems = OrderItem::where('order_id', $orderId)->get();
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

        $orderItem = OrderItem::findOrFail($id);
        $orderItem->update([
            'order_id' => $validated['order_id'],
            'menu_id' => $validated['menu_id'],
            'quantity' => $validated['quantity'],
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
        $orderItem = OrderItem::findOrFail($id);
        $orderItem->update(['status' => 1]);

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
        $orderItem = OrderItem::findOrFail($id);
        $orderItem->update(['status' => -1]);

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
        $orderItem = OrderItem::findOrFail($id);
        $orderItem->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Order item deleted successfully'
        ]);
    }
}
