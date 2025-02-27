<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Product;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders;
        return view('orders.index', compact('orders'));
    }

    public function create(Product $product)
    {
        return view('orders.create', compact('product'));
    }

    public function store(Request $request, $product_id)
    {
        $product = Product::findOrFail($product_id);
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->available_stock,
        ], [
            'quantity.required' => 'The quantity field is required.',
            'quantity.integer' => 'The quantity must be an integer.',
            'quantity.min' => 'The minimum quantity you can order is 1.',
            'quantity.max' => 'The quantity cannot exceed the available stock of ' . $product->available_stock . '.',
        ]);

        $totalPrice = $product->price * $request->quantity;

        Order::create([
            'user_id' => auth()->id(),
            'product_id' => $product_id,
            'quantity' => $request->quantity,
            'total_price' => $totalPrice,
        ]);

        $product->decrement('available_stock', $request->quantity);

        return redirect()->route('orders.index')->with('success', 'Order placed!');
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'order_details' => 'required',
    //     ]);

    //     $orderDetails = json_decode($request->order_details, true);
    //     $totalPrice = 0;

    //     foreach ($orderDetails as $orderItem) {
    //         $product = Product::findOrFail($orderItem['product_id']);

    //         if ($orderItem['quantity'] > $product->stock) {
    //             return redirect()->back()->with('error', 'Insufficient stock for ' . $product->name);
    //         }

    //         $totalPrice += $product->price * $orderItem['quantity'];
    //     }

    //     // $order = Order::create([
    //     //     'user_id' => auth()->id(),
    //     //     'total_price' => $totalPrice,
    //     // ]);

    //     foreach ($orderDetails as $orderItem) {
    //         $product = Product::findOrFail($orderItem['product_id']);

    //         // $order->orderItems()->create([
    //         //     'product_id' => $product->id,
    //         //     'quantity' => $orderItem['quantity'],
    //         //     'price' => $product->price
    //         // ]);

    //         Order::create([
    //             'user_id' => auth()->id(),
    //             'product_id' => $product->id,
    //             'quantity' => $orderItem['quantity'],
    //             'total_price' => $product->price * $orderItem['quantity'],
    //         ]);

    //         $product->decrement('stock', $orderItem['quantity']);
    //     }

    //     return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
    // }
}
