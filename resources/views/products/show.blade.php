@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="row">
        <div class="col-md-6">
            <img src="{{ $product->images ? (filter_var($product->images, FILTER_VALIDATE_URL) ? $product->images : asset($product->images)) : 'https://via.placeholder.com/700x500?text=Product' }}" class="img-fluid rounded" alt="{{ $product->name }}">
        </div>
        <div class="col-md-6">
            <h1>{{ $product->name }}</h1>
            <p class="text-muted">SKU: {{ $product->slug }}</p>
            <p class="fs-4 text-primary mb-3">${{ number_format($product->price, 2) }}</p>
            <p>{{ $product->description ?? 'No description available.' }}</p>
            <p class="mb-3">
                <strong>Stock:</strong> {{ $product->stock }}</p>
            <form method="POST" action="{{ route('cart.add', $product) }}">
                @csrf
                <button class="btn btn-primary">Add to cart</button>
            </form>
        </div>
    </div>
@endsection
