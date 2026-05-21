@extends('admin.layouts.app')

@section('title', 'Customer Details')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3">{{ $customer->name }}</h1>
            <p class="text-muted mb-0">{{ $customer->email }}</p>
        </div>
        <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary">Back to Customers</a>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Account Details</h5>
                    <p><strong>Registered:</strong> {{ $customer->created_at->format('Y-m-d H:i') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Order Summary</h5>
                    <p><strong>Total Orders:</strong> {{ $customer->orders->count() }}</p>
                    <p><strong>Last Order:</strong>
                        @if($customer->orders->isNotEmpty())
                            #{{ $customer->orders->first()->id }} on {{ $customer->orders->first()->created_at->format('Y-m-d') }}
                        @else
                            None
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Customer Orders</h5>

            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Order ID</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Placed At</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customer->orders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>{{ ucfirst($order->status) }}</td>
                                <td>{{ number_format($order->total, 2) }} {{ $order->currency }}</td>
                                <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">This customer has not placed any orders yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
