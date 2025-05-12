<?php

namespace App\Services;

use App\Models\OrderItem;

/**
 * Class OrderItemService.
 */
class OrderItemService
{
    /**
     * Get all order items.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllOrderItems()
    {
        return OrderItem::all();
    }

    /**
     * Get a single order item by ID.
     *
     * @param int $id
     * @return \App\Models\OrderItem|null
     */
    public function getOrderItemById($id)
    {
        return OrderItem::find($id);
    }
    /**
     * Get order items by order ID.
     *
     * @param int $orderId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getOrderItemsByOrderId($orderId)
    {
        return OrderItem::where('order_id', $orderId)->get();
    }
    
    /**
     * Create a new order item.
     *
     * @param array $data
     * @return \App\Models\OrderItem
     */
    public function createOrderItem(array $data)
    {
        return OrderItem::create($data);
    }

    /**
     * Update an existing order item.
     *
     * @param \App\Models\OrderItem $orderItem
     * @param array $data
     * @return bool
     */
    public function updateOrderItem(OrderItem $orderItem, array $data)
    {
        return $orderItem->update($data);
    }

    /**
     * Delete an order item.
     *
     * @param \App\Models\OrderItem $orderItem
     * @return bool|null
     */
    public function deleteOrderItem(OrderItem $orderItem)
    {
        return $orderItem->delete();
    }
}
