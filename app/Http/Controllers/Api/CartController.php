<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return response()->json(session()->get('cart', []));
    }

    public function add(Product $product)
    {
        $cart = session()->get('cart', []);

        $cart[$product->id] = [
            'name' => $product->name,
            'quantity' => ($cart[$product->id]['quantity'] ?? 0) + 1,
            'price' => $product->price,
        ];

        session()->put('cart', $cart);

        return response()->json(['success' => true]);
    }

    public function update(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);
        $quantity = max(1, (int) $request->input('quantity', 1));

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] = $quantity;
            session()->put('cart', $cart);
        }

        return response()->json(['success' => true]);
    }

    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session()->put('cart', $cart);
        }

        return response()->json(['success' => true]);
    }
}
