@extends('layouts.app')

@section('title', 'Manage Products')

@section('content')
<div class="container">
    <h2>Product List</h2>
    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Add Product</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Total Stock</th>
                <th>Available Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>${{ $product->price }}</td>
                    <td>{{ $product->total_stock }}</td>
                    <td>{{ $product->available_stock }}</td>
                    <td>
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm delete-btn" data-name="{{ $product->name }}">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function () {
        $(document).on('click', '.delete-btn', function (e) {
            e.preventDefault(); // Prevent the default form submission
            let productName = $(this).data('name');
            let form = $(this).closest('form');

            if (confirm('Are you sure you want to delete ' + productName + '?')) {
                form.submit(); // Submit the form if confirmed
            }
        });
    });
</script>
@endsection
