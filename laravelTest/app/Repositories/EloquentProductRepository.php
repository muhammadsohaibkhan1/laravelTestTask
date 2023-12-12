<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class EloquentProductRepository
 * @package App\Repositories
 */
class EloquentProductRepository implements ProductRepositoryInterface
{
    /**
     * Get all products.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return Product::all();
    }

    /**
     * Find a product by ID.
     *
     * @param int $id
     * @return \App\Models\Product|null
     */
    public function findProductById($id)
    {
        return Product::find($id);
    }

    /**
     * Create a new product.
     *
     * @param array $data
     * @return \App\Models\Product
     * @throws \Exception
     */
    public function createProduct(array $data)
    {
        try {
            DB::beginTransaction();

            $data['sellerId'] = auth()->user()->id;
            $product = Product::create($data);

            DB::commit();

            return $product;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error in EloquentProductRepository::createProductById(): ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Update a product by ID.
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\Product|null
     * @throws \Exception
     */
    public function updateProductById($id, array $data)
    {
        try {
            DB::beginTransaction();

            $product = Product::find($id);
            $product->update($data);

            DB::commit();

            return $product;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error in EloquentProductRepository::updateProductById(): ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Delete a product by ID.
     *
     * @param int $id
     * @return void
     * @throws \Exception
     */
    public function deleteProductById($id)
    {
        try {
            DB::beginTransaction();

            $product = Product::find($id);
            $product->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error in EloquentProductRepository::deleteProductById(): ' . $e->getMessage());
            throw $e;
        }
    }
}
