<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Http\Requests\APIS\CreateProductRequest;
use App\Http\Requests\APIs\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Repositories\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Get all products.
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $products = $this->productRepository->all();
            return response()->json(['response' => ['status' => true, 'data' => ProductResource::collection($products)]], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Error in ProductController@index: ' . $e->getMessage());
            return response()->json(['response' => ['status' => false, 'error' => 'An error occurred while fetching products']], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get a specific product by ID.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        try {
            $product = $this->productRepository->findProductById($id);

            if (!$product) {
                return response()->json(['response' => ['status' => false, 'error' => 'Product not found']], JsonResponse::HTTP_NOT_FOUND);
            }

            return response()->json(['response' => ['status' => true, 'data' => new ProductResource($product)]], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Error in ProductController@show: ' . $e->getMessage());
            return response()->json(['response' => ['status' => false, 'error' => 'An error occurred while fetching the product']], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Create a new product.
     *
     * @param CreateProductRequest $request
     * @return JsonResponse
     */
    public function store(CreateProductRequest $request)
    {
        try {
            $product = $this->productRepository->createProduct($request->validated());

            return response()->json(['response' => ['status' => true, 'data' => new ProductResource($product)]], JsonResponse::HTTP_CREATED);
        } catch (\Exception $e) {
            Log::error('Error in ProductController@store: ' . $e->getMessage());
            return response()->json(['response' => ['status' => false, 'error' => 'An error occurred while creating the product']], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update a product by ID.
     *
     * @param UpdateProductRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateProductRequest $request, $id)
    {
        try {
            $product = $this->productRepository->updateProductById($id, $request->validated());

            return response()->json(['response' => ['status' => true, 'data' => new ProductResource($product)]], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Error in ProductController@update: ' . $e->getMessage());
            return response()->json(['response' => ['status' => false, 'error' => 'An error occurred while updating the product']], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Delete a product by ID.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        try {
            $this->productRepository->deleteProductById($id);

            return response()->json(['response' => ['status' => true, 'message' => 'Product deleted successfully']], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Error in ProductController@destroy: ' . $e->getMessage());
            return response()->json(['response' => ['status' => false, 'error' => 'An error occurred while deleting the product']], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
