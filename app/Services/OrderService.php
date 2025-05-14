<?php

namespace App\Services;

use App\Models\Order;

/**
 * Class OrderService.
 */
class OrderService
{
    /**
     * Get all orders.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllOrders()
    {
        return Order::all();
    }

    /**
     * Get an order by ID.
     *
     * @param string $id
     * @return \App\Models\Order|null
     */
    public function getOrderById(string $id)
    {
        return Order::find($id);
    }
    /**
     * Get an order by order ID.
     *
     * @param string $orderId
     * @return \App\Models\Order|null
     */
    public function getOrderByOrderId(string $orderId)
    {
        return Order::where('order_id', $orderId)->first();
    }

    /**
     * Get orders by user ID.
     *
     * @param string $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getOrdersByUserId(string $userId)
    {
        return Order::where('user_id', $userId)->get();
    }

    /**
     * Create a new order.
     *
     * @param array $data
     * @return \App\Models\Order
     */
    public function createOrder(array $data)
    {
        return Order::create($data);
    }

    /**
     * Update an existing order.
     *
     * @param \App\Models\Order $order
     * @param array $data
     * @return bool
     */
    public function updateOrder(Order $order, array $data)
    {
        return Order::where('order_id', $order->order_id)->update($data);
    }

    /**
     * Delete an order.
     *
     * @param \App\Models\Order $order
     * @return bool|null
     */
    public function deleteOrder(Order $order)
    {
        return $order->delete();
    }
}
