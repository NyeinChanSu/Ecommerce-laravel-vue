<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('products.index')->with('info', 'Your cart is empty.');
        }

        return view('checkout.index', compact('cart'));
    }

    public function process(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('products.index')->with('info', 'Your cart is empty.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'postcode' => 'required|string|max:50',
            'country' => 'required|string|max:100',
            'phone' => 'required|string|max:50',
        ]);

        $total = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        $order = Order::create([
            'user_id' => auth()->id(),
            'status' => 'pending',
            'total' => $total,
            'currency' => 'USD',
            'payment_ref' => 'COD-' . strtoupper(uniqid()),
            'shipping_address' => [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'address' => $validated['address'],
                'city' => $validated['city'],
                'postcode' => $validated['postcode'],
                'country' => $validated['country'],
                'phone' => $validated['phone'],
            ],
        ]);

        foreach ($cart as $productId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => (int) $productId,
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
                'subtotal' => $item['price'] * $item['quantity'],
            ]);
        }

        session()->forget('cart');

        return redirect()->route('orders.show', $order)->with('success', 'Order placed successfully!');
    }
}
