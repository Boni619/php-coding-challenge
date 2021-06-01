<?php

namespace App\Http\Controllers;

use App\Service\ApiServiceInterface;
use Illuminate\Http\Request;
use Validator;

class CartController extends Controller
{
    protected $apiService;

    public function __construct(ApiServiceInterface $apiService)
    {
        $this->apiService = $apiService;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required',
            'product_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $cart = $this->apiService->cartStore($request->all());

        return response()->json([
            'message' => 'Cart successfully added',
            'product' => $cart
        ], 200);
    }

    public function userCart()
    {
        $products = $this->apiService->userCartDetail();

        return response()->json([
            'message' => 'Cart details',
            'products' => $products
        ], 200);
    }
}
