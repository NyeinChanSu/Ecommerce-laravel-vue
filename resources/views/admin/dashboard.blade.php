@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="mb-4">
        <h1 class="h3">Admin Dashboard</h1>
        <p class="text-muted">Welcome, {{ auth('admin')->user()->name }}.</p>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-start border-4 border-primary shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Products</h5>
                    <p class="display-6 mb-0">{{ $productsCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-start border-4 border-success shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Categories</h5>
                    <p class="display-6 mb-0">{{ $categoriesCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-start border-4 border-warning shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Orders</h5>
                    <p class="display-6 mb-0">{{ $ordersCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-start border-4 border-info shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Customers</h5>
                    <p class="display-6 mb-0">{{ $customersCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Recent Orders</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Order</th>
                            <th>Customer</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                            <tr>
                                <td><a href="{{ route('admin.orders.show', $order) }}">#{{ $order->id }}</a></td>
                                <td>{{ $order->customer->name ?? 'Guest' }}</td>
                                <td>{{ ucfirst($order->status) }}</td>
                                <td>{{ number_format($order->total, 2) }} {{ $order->currency }}</td>
                                <td>{{ $order->created_at->format('Y-m-d') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">No recent orders.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
