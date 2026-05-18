@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
    <h1 class="h3 mb-4">Shopping Cart</h1>

    @if(empty($cart))
        <div class="alert alert-info">Your cart is empty. Browse our <a href="{{ route('products.index') }}">products</a>.</div>
    @else
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-end">Price</th>
                        <th class="text-end">Subtotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($cart as $productId => $item)
                        @php $subtotal = $item['quantity'] * $item['price']; $total += $subtotal; @endphp
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td class="text-center">
                                <form method="POST" action="{{ route('cart.update', ['product' => $productId]) }}" class="d-inline-flex align-items-center">
                                    @csrf
                                    <input type="number" name="quantity" min="1" value="{{ $item['quantity'] }}" class="form-control form-control-sm w-25">
                                    <button class="btn btn-sm btn-outline-secondary ms-2">Update</button>
                                </form>
                            </td>
                            <td class="text-end">${{ number_format($item['price'], 2) }}</td>
                            <td class="text-end">${{ number_format($subtotal, 2) }}</td>
                            <td class="text-end">
                                <form method="POST" action="{{ route('cart.remove', ['product' => $productId]) }}">
                                    @csrf
                                    <button class="btn btn-sm btn-danger">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end"><strong>Total</strong></td>
                        <td class="text-end"><strong>${{ number_format($total, 2) }}</strong></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Continue shopping</a>
            <a href="{{ route('checkout.index') }}" class="btn btn-primary">Proceed to checkout</a>
        </div>
    @endif
@endsection
