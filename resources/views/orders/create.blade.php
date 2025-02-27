@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Place Order</h2>

    <div class="card p-3">
        <h4>Product: {{ $product->name }}</h4>
        <p>Price: ${{ $product->price }}</p>
        <p>Stock Available: {{ $product->available_stock }}</p>
    </div>

    <form action="{{ route('orders.store', $product->id) }}" method="POST" class="mt-3">
        @csrf

        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" id="quantity" name="quantity" class="form-control" min="1" max="{{ $product->available_stock }}" value="1" required>
            @error('quantity')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="total_price" class="form-label">Total Price ($)</label>
            <input type="text" id="total_price" class="form-control" value="{{ $product->price }}" readonly>
        </div>

        <button type="submit" class="btn btn-success">Place Order</button>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const $quantityInput = $('#quantity');
        const $totalPriceInput = $('#total_price');
        const productPrice = {{ $product->price }};
        const maxStock = {{ $product->available_stock }};

        $quantityInput.on('input', function () {
            let quantity = parseInt($quantityInput.val()) || 1;
            if (quantity < 1) quantity = 1;
            if (quantity > maxStock) quantity = maxStock;
            $totalPriceInput.val((quantity * productPrice).toFixed(2));
        });
    });
</script>
@endsection
