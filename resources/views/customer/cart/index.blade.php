@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center">🛒 Your Cart</h2>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    @if(count($cart) > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($cart as $id => $item)
                    @php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; @endphp
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td><img src="{{ asset('storage/'.$item['image']) }}" width="60"></td>
                        <td>₹{{ $item['price'] }}</td>
                        <td>
                            <form action="{{ route('cart.update', $id) }}" method="POST" class="d-inline">
                                @csrf
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" style="width:60px;">
                                <button class="btn btn-sm btn-secondary">Update</button>
                            </form>
                        </td>
                        <td>₹{{ $subtotal }}</td>
                        <td>
                            <form action="{{ route('cart.remove', $id) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <h4 class="text-end">Total: ₹{{ $total }}</h4>
        <div class="text-end">
            <a href="#" class="btn btn-success mt-3">Proceed to Checkout</a>
        </div>
    @else
        <p class="text-center text-muted">Your cart is empty 😔</p>
    @endif
</div>
@endsection
