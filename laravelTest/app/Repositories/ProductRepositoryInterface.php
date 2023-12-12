<?php

namespace App\Repositories;

/**
 * Interface ProductRepositoryInterface
 * @package App\Repositories
 */
interface ProductRepositoryInterface
{
    /**
     * Get all products.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all();

    /**
     * Find a product by ID.
     *
     * @param int $id
     * @return \App\Models\Product|null
     */
    public function findProductById($id);

    /**
     * Create a new product.
     *
     * @param array $data
     * @return \App\Models\Product
     */
    public function createProduct(array $data);

    /**
     * Update a product by ID.
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\Product|null
     */
    public function updateProductById($id, array $data);

    /**
     * Delete a product by ID.
     *
     * @param int $id
     * @return void
     */
    public function deleteProductById($id);
}
