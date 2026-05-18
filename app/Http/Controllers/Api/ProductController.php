<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(12);

        return response()->json($products);
    }

    public function show(Product $product)
    {
        return response()->json($product);
    }
}
