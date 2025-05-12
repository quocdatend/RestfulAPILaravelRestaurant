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
        return $order->update($data);
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
