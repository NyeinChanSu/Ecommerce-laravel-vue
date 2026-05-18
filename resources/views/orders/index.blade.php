@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
    <h1 class="h3 mb-4">My Orders</h1>

    @if($orders->isEmpty())
        <div class="alert alert-info">You have not placed any orders yet.</div>
    @else
        <div class="list-group">
            @foreach($orders as $order)
                <a href="{{ route('orders.show', $order) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Order #{{ $order->id }}</strong>
                        <div class="text-muted">Placed on {{ $order->created_at->format('M d, Y') }}</div>
                    </div>
                    <div class="text-end">
                        <div class="fw-semibold">${{ number_format($order->total, 2) }}</div>
                        <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-4">{{ $orders->links() }}</div>
    @endif
@endsection
