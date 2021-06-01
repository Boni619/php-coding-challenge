<?php

namespace App\Service;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;

class ApiService implements ApiServiceInterface
{
    public function getProducts()
    {
        $product = Product::all();

        return $product;
    }

    public function productStore($formData)
    {
        $product = Product::create($formData);

        return $product;
    }

    public function getCategories()
    {
        $category = Category::all();

        return $category;
    }

    public function productByCategory($cat_id)
    {
        //return $cat_id;
        $category = Category::with('products')->where('id', $cat_id)->first();

        return $category->products;
    }

    public function cartStore($formData)
    {
        $user = auth()->user();

        $isExists = Cart::where('product_id', $formData['product_id'])->where('user_id', $user->id)->first();

        if (! empty($isExists)) {
            $cart = Cart::where('product_id', $formData['product_id'])->where('user_id', $user->id)->update(['quantity' => $formData['quantity']]);
        } else {
            $data = [];
            $data['product_id'] = $formData['product_id'];
            $data['user_id'] = $user->id;
            $data['quantity'] = $formData['quantity'];
            $cart = Cart::create($data);
        }

        return $cart;
    }

    public function userCartDetail()
    {
        $user = auth()->user();
        $carts = Cart::with('products')->where('user_id', $user->id)->get();

        $products = [];

        foreach ($carts as $cart) {
            $products[] = $cart->products;
        }

        return $products;
    }
}
