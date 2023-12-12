<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Http\Requests\APIs\CreateProductRequest;
use App\Http\Requests\APIs\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Repositories\ProductRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        try {
            $products = $this->productRepository->all();
            $data = ProductResource::collection($products);
            return response()->json(['status' => true, 'data' => ['products' => $data]], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Error in ProductController@index: ' . $e->getMessage());
            return response()->json(['status' => false, 'error' => 'An error occurred while fetching products.'], JsonResponse::HTTP_UNAUTHORIZED);
        }
    }

    public function show($id)
    {
        try {
            $product = $this->productRepository->findProductById($id);
            $data = new ProductResource($product);
            return response()->json(['status' => true, 'data' => ['product' => $data]], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Error in ProductController@show(' . $id . '): ' . $e->getMessage());
            return response()->json(['status' => false, 'error' => 'An error occurred while showing product.'], JsonResponse::HTTP_UNAUTHORIZED);
        }
    }

    public function store(CreateProductRequest $request)
    {
        try {
            $data = $request->all();

            DB::beginTransaction();
            $product = $this->productRepository->createProduct($data);
            DB::commit();

            $responseData = new ProductResource($product);
            return response()->json(['status' => true, 'data' => ['product' => $responseData]], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error in ProductController@store: ' . $e->getMessage());
            return response()->json(['status' => false, 'error' => 'An error occurred while creating product.'], JsonResponse::HTTP_UNAUTHORIZED);
        }
    }

    public function update($id, UpdateProductRequest $request)
    {
        try {
            $data = $request->all();

            DB::beginTransaction();
            $product = $this->productRepository->updateProductById($id, $data);
            DB::commit();

            $responseData = new ProductResource($product);
            return response()->json(['status' => true, 'data' => ['product' => $responseData]], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error in ProductController@update(' . $id . '): ' . $e->getMessage());
            return response()->json(['status' => false, 'error' => 'An error occurred while updating product.'], JsonResponse::HTTP_UNAUTHORIZED);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $result = $this->productRepository->deleteProductById($id);
            DB::commit();

            $responseData = new ProductResource($result);
            return response()->json(['status' => true, 'data' => ['product' => $responseData]], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error in ProductController@destroy(' . $id . '): ' . $e->getMessage());
            return response()->json(['status' => false, 'error' => 'An error occurred while deleting product.'], JsonResponse::HTTP_UNAUTHORIZED);
        }
    }
}
