<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Http\Requests\APIs\CreateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Repositories\OrderRepositoryInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class OrderController
 * @package App\Http\Controllers\APIs
 */
class OrderController extends Controller
{
    /**
     * @var OrderRepositoryInterface
     */
    protected $orderRepository;

    /**
     * OrderController constructor.
     *
     * @param OrderRepositoryInterface $orderRepository
     */
    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * Display a listing of the orders.
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $orders = $this->orderRepository->allOrders();

            return response()->json(['response' => ['status' => true, 'data' => OrderResource::collection($orders)]], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['response' => ['status' => false, 'error' => $e->getMessage()]], JsonResponse::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Show the form for creating a new order.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(CreateOrderRequest $request)
    {
        try {
            $orderData = $request->only(['buyerId', 'productId', 'quantity']);

            $order = $this->orderRepository->createOrder($orderData);

            return response()->json(['response' => ['status' => true, 'data' => new OrderResource($order)]], JsonResponse::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['response' => ['status' => false, 'error' => $e->getMessage()]], JsonResponse::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Display the specified order.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        try {
            $order = $this->orderRepository->findOrdersByProductId($id);

            if (!$order) {
                return response()->json(['response' => ['status' => false, 'error' => 'Order not found']], JsonResponse::HTTP_NOT_FOUND);
            }

            return response()->json(['response' => ['status' => true, 'data' => new OrderResource($order)]], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['response' => ['status' => false, 'error' => $e->getMessage()]], JsonResponse::HTTP_UNAUTHORIZED);
        }
    }
}
