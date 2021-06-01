<?php

namespace App\Http\Controllers;

use App\Service\ApiServiceInterface;
use Illuminate\Http\Request;
use Validator;

class CategoryController extends Controller
{
    protected $apiService;

    public function __construct(ApiServiceInterface $apiService)
    {
        $this->apiService = $apiService;
    }

    public function index()
    {
        $category = $this->apiService->getCategories();

        return response()->json([
            'message' => 'Category list',
            'category' => $category
        ], 200);
    }

    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $products = $this->apiService->productByCategory($request->category_id);

        return response()->json([
            'message' => 'Category details',
            'products' => $products
        ], 200);
    }
}
