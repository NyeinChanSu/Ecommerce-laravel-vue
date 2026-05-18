@extends('layouts.app')

@section('title', 'Shop')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3">Shop</h1>
            <p class="text-muted">Browse products and add items to your cart.</p>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach($products as $product)
            <div class="col">
                <div class="card h-100">
                    <img src="{{ $product->images ? (filter_var($product->images, FILTER_VALIDATE_URL) ? $product->images : asset($product->images)) : 'https://via.placeholder.com/400x300?text=Product' }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text text-truncate">{{ Str::limit($product->description, 100) }}</p>
                        <p class="fs-5 text-primary mb-3">${{ number_format($product->price, 2) }}</p>
                        <div class="mt-auto d-grid gap-2">
                            <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary">View details</a>
                            <form method="POST" action="{{ route('cart.add', $product) }}">
                                @csrf
                                <button type="submit" class="btn btn-primary">Add to cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">{{ $products->links() }}</div>
@endsection
