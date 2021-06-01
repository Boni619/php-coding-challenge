<?php

namespace App\Http\Controllers;

use App\Service\ApiServiceInterface;
use Illuminate\Http\Request;
use Validator;

class ProductController extends Controller
{
    protected $apiService;

    public function __construct(ApiServiceInterface $apiService)
    {
        $this->apiService = $apiService;
    }

    public function index()
    {
        $products = $this->apiService->getProducts();

        return response()->json([
            'message' => 'Products list',
            'product' => $products
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'category_id' => 'required',
            'description' => 'required',
            'price' => 'required',
            'make' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $product = $this->apiService->productStore($request->all());

        return response()->json([
            'message' => 'Product successfully added',
            'product' => $product
        ], 200);
    }
}
