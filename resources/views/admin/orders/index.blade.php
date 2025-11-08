@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-3">📦 All Orders</h2>

    @if($orders->count())
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Customer</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Placed At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->name ?? 'N/A' }}</td>
                    <td><span class="badge bg-info">{{ ucfirst($order->status) }}</span></td>
                    <td>₹{{ $order->total_amount }}</td>
                    <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-primary">View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $orders->links() }}
    @else
        <p>No orders yet.</p>
    @endif
</div>
@endsection
