@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center">🍕 Our Delicious Menu</h2>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <div class="row">
        @foreach($items as $item)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <img src="{{ asset('storage/'.$item->image) }}" class="card-img-top" alt="{{ $item->name }}">
                <div class="card-body text-center">
                    <h5 class="card-title">{{ $item->name }}</h5>
                    <p class="card-text text-muted">{{ $item->category->name }}</p>
                    <p><strong>₹{{ $item->price }}</strong></p>
                    <form action="{{ route('cart.add', $item->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-primary w-100">Add to Cart</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
