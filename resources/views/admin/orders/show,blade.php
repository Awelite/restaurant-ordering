@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2>Order #{{ $order->id }}</h2>

    <div class="card mb-3">
        <div class="card-body">
            <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
            <p><strong>Customer:</strong> {{ $order->user->name ?? 'N/A' }} ({{ $order->user->email ?? '' }})</p>
            <p><strong>Address:</strong> {{ $order->address }}</p>
            <p><strong>Phone:</strong> {{ $order->phone }}</p>
            <p><strong>Payment:</strong> {{ $order->payment_method }}</p>
            <p><strong>Notes:</strong> {{ $order->notes ?? '-' }}</p>
        </div>
    </div>

    <h5>Items</h5>
    <table class="table">
        <thead>
            <tr>
                <th>Item</th>
                <th>Qty</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
                <tr>
                    <td>{{ $item->menuItem?->name ?? 'Removed item' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>₹{{ $item->price }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4 class="text-end">Total: ₹{{ $order->total_amount }}</h4>

    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary mt-3">⬅ Back</a>
</div>
@endsection
