@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <h2>Welcome, {{ auth()->user()->name }}</h2>
    @if(auth()->user()->role == 'admin')
        <p><a href="{{ route('products.index') }}" class="btn btn-primary">Manage Products</a></p>
    @else
        <p><a href="{{ route('orders.index') }}" class="btn btn-success">View Orders</a></p>

        <div class="row">
            @foreach ($products as $product)
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">Price: ${{ $product->price }}</p>
                            <p class="card-text">Stock: {{ $product->available_stock }} </p>
                            <a href="{{ route('orders.create', $product->id) }}" class="btn btn-primary">Place Order</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
