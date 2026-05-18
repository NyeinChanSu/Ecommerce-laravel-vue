@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <div class="row">
        <div class="col-lg-7">
            <h1 class="h3 mb-4">Checkout</h1>

            <form method="POST" action="{{ route('checkout.process') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <input type="text" name="address" value="{{ old('address') }}" class="form-control" required>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">City</label>
                        <input type="text" name="city" value="{{ old('city') }}" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Postal Code</label>
                        <input type="text" name="postcode" value="{{ old('postcode') }}" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Country</label>
                        <input type="text" name="country" value="{{ old('country') }}" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3 mt-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Place order</button>
            </form>
        </div>

        <div class="col-lg-5">
            <div class="card p-4 mb-4">
                <h2 class="h5">Order summary</h2>
                <ul class="list-group list-group-flush mb-3">
                    @php $cartTotal = 0; @endphp
                    @foreach($cart as $item)
                        @php $itemTotal = $item['price'] * $item['quantity']; $cartTotal += $itemTotal; @endphp
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $item['name'] }}</strong>
                                <div class="text-muted">Qty: {{ $item['quantity'] }}</div>
                            </div>
                            <span>${{ number_format($itemTotal, 2) }}</span>
                        </li>
                    @endforeach
                </ul>

                <div class="d-flex justify-content-between fw-semibold">
                    <span>Total</span>
                    <span>${{ number_format($cartTotal, 2) }}</span>
                </div>

                <p class="text-muted mt-3 mb-0">Payment is processed after order placement. This demo uses a simple order workflow.</p>
            </div>
        </div>
    </div>
@endsection
