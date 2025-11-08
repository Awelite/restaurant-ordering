@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2>✅ Order Placed</h2>
    <p>Thank you — your order <strong>#{{ $order->id }}</strong> has been placed.</p>

    <div class="card mb-3">
        <div class="card-body">
            <h5>Order Details</h5>
            <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
            <p><strong>Placed at:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>
            <p><strong>Address:</strong> {{ $order->address }}</p>
            <p><strong>Phone:</strong> {{ $order->phone }}</p>
            <p><strong>Payment:</strong> {{ $order->payment_method }}</p>
        </div>
    </div>

    <h5>Items</h5>
    <table class="table">
        <thead><tr><th>Item</th><th>Qty</th><th>Price</th></tr></thead>
        <tbody>
            @foreach($order->orderItems as $oi)
            <tr>
                <td>{{ $oi->menuItem?->name ?? 'Item removed' }}</td>
                <td>{{ $oi->quantity }}</td>
                <td>₹{{ $oi->price }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h4 class="text-end">Total: ₹{{ $order->total_amount }}</h4>

    <a href="{{ route('customer.menu') }}" class="btn btn-primary mt-3">Back to Menu</a>
</div>
@endsection
