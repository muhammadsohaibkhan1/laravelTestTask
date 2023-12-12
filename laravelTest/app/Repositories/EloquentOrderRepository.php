<?php

namespace App\Repositories;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class OrderEloquentRepository
 * @package App\Repositories
 */
class EloquentOrderRepository implements OrderRepositoryInterface
{
    /**
     * Get all orders.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     * @throws \Exception
     */
    public function allOrders()
    {
        try {
            return Order::with('buyer', 'product')->get();
        } catch (\Exception $e) {
            Log::error('Error in OrderEloquentRepository::allOrders(): ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Find an order by ID.
     *
     * @param int $id
     * @return \App\Models\Order|null
     * @throws \Exception
     */
    public function findOrdersByProductId($id)
    {
        try {
            return Order::where('productId',$id)->with('buyer', 'product')->get();
        } catch (\Exception $e) {
            Log::error('Error in OrderEloquentRepository::findOrdersById(' . $id . '): ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Create a new order.
     *
     * @param array $data
     * @return \App\Models\Order
     * @throws \Exception
     */
    public function createOrder(array $data)
    {
        try {
            DB::beginTransaction();

            $data['buyerId'] = auth()->user()->id;
            $order = Order::create($data);

            DB::commit();

            return $order;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error in OrderEloquentRepository::createOrder(): ' . $e->getMessage());
            throw $e;
        }
    }
}
