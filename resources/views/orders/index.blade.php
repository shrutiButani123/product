@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="container">
    <h2>My Orders</h2>
    @if(isset($orders))
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Ordered On</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->product->name }}</td>
                        <td>{{ $order->quantity }}</td>
                        <td>${{ $order->total_price }}</td>
                        <td>{{ $order->created_at->format('d-m-Y') }}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>      
    @else
        <h4>Order not found</h4>
    @endif
</div>
@endsection
