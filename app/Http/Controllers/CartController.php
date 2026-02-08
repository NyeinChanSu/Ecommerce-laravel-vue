<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return CartItem::with('product')->where('user_id', $user->id)->get();
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        $cartItem = CartItem::updateOrCreate(
            ['user_id' => $user->id, 'product_id' => $product->id],
            [
                'quantity' => $validated['quantity'],
                'unit_price' => $product->price,
                'subtotal' => $product->price * $validated['quantity'],
            ]
        );

        return response()->json($cartItem, 201);
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $user = Auth::user();

        if ($cartItem->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem->update([
            'quantity' => $validated['quantity'],
            'subtotal' => $cartItem->unit_price * $validated['quantity'],
        ]);

        return response()->json($cartItem);
    }

    public function destroy(CartItem $cartItem)
    {
        $user = Auth::user();

        if ($cartItem->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $cartItem->delete();

        return response()->json(null, 204);
    }
}
