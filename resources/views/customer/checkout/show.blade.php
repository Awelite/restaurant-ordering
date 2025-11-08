@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">🧾 Checkout</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('customer.checkout.process') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Delivery Address</label>
                    <textarea name="address" class="form-control" required>{{ old('address') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input name="phone" type="text" value="{{ old('phone', auth()->user()->phone ?? '') }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Payment Method</label>
                    <select name="payment_method" class="form-control">
                        <option value="COD">Cash on Delivery (COD)</option>
                        <option value="Razorpay">Online (Razorpay) — Coming soon</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Notes (optional)</label>
                    <textarea name="notes" class="form-control">{{ old('notes') }}</textarea>
                </div>

                <!-- optional lat/lng if you collect from front-end map -->
                <input type="hidden" name="address_lat" id="address_lat" value="{{ old('address_lat') }}">
                <input type="hidden" name="address_lng" id="address_lng" value="{{ old('address_lng') }}">

                <button class="btn btn-success">Place Order — Pay on Delivery</button>
            </form>
        </div>

        <div class="col-md-6">
            <h5>Order summary</h5>
            <table class="table">
                <thead><tr><th>Item</th><th>Qty</th><th>Subtotal</th></tr></thead>
                <tbody>
                    @php $grand = 0; @endphp
                    @foreach($cart as $id => $item)
                        @php $subtotal = $item['price'] * $item['quantity']; $grand += $subtotal; @endphp
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>₹{{ $subtotal }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <h4 class="text-end">Total: ₹{{ $total }}</h4>
        </div>
    </div>
</div>

<!-- Optional: include Google Maps / place-picker to set address_lat/lng -->
@endsection
