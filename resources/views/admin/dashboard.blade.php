@extends('layouts.app')

@section('content')
<div class="container text-center py-5">
    <h1>👨‍🍳 Admin Dashboard</h1>
    <p>Welcome, {{ Auth::user()->name }}</p>
</div>
@endsection
