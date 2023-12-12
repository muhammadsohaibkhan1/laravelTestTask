<?php

namespace App\Repositories;

/**
 * Interface OrderRepositoryInterface
 * @package App\Repositories
 */
interface OrderRepositoryInterface
{
    /**
     * Get all orders.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function allOrders();

    /**
     * Find an order by ID.
     *
     * @param int $id
     * @return \App\Models\Order|null
     */
    public function findOrdersByProductId($id);

    /**
     * Create a new order.
     *
     * @param array $data
     * @return \App\Models\Order
     */
    public function createOrder(array $data);
}
