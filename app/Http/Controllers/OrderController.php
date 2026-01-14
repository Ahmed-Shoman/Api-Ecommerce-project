<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index()
    {
        return Order::with(['products', 'user', 'location'])
            ->latest()
            ->get();
    }

    /**
     * Store a newly created order.
     */
    public function store(Request $request)
    {
        $request->validate([
            'location_id' => 'required|exists:locations,id',
            'delivery_of_delivery' => 'required|string',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $totalPrice = 0;

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'location_id' => $request->location_id,
                'delivery_of_delivery' => $request->delivery_of_delivery,
                'status' => 'pending',
                'total_price' => 0, // will update later
            ]);

            foreach ($request->products as $item) {
                $product = Product::findOrFail($item['product_id']);

                $price = $product->price * $item['quantity'];
                $totalPrice += $price;

                $order->products()->attach($product->id, [
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                ]);
            }

            // Update total price
            $order->update([
                'total_price' => $totalPrice
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Order created successfully',
                'order' => $order->load('products')
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified order.
     */
    public function show($id)
    {
        return Order::with(['products', 'user', 'location'])
            ->findOrFail($id);
    }

    /**
     * Update order status.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,accepted,out_for_delivery,delivered,cancelled'
        ]);

        $order = Order::findOrFail($id);
        $order->update([
            'status' => $request->status
        ]);

        return response()->json([
            'message' => 'Order status updated successfully',
            'order' => $order
        ]);
    }

    /**
     * Remove the specified order.
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return response()->json([
            'message' => 'Order deleted successfully'
        ]);
    }

    public function get_order_items($id)
{
    $order_items = OrderItems::where('order_id', $id)->get();

    if ($order_items->isEmpty()) {
        return response()->json('no items found');
    }

    foreach ($order_items as $order_item) {
        $product = Product::where('id', $order_item->product_id)
            ->pluck('name')
            ->first();

        $order_item->product_name = $product;
    }

    return response()->json($order_items);
}

public function get_user_orders($id)
{
    $orders = Order::where('user_id', $id)
        ->with('orderItems')
        ->orderBy('created_at', 'desc')
        ->get();

    if ($orders->isEmpty()) {
        return response()->json('no orders found for this user');
    }

    foreach ($orders as $order) {
        foreach ($order->orderItems as $item) {
            $product = Product::where('id', $item->product_id)
                ->pluck('name')
                ->first();

            $item->product_name = $product;
        }
    }

    return response()->json($orders);
}

public function cahnge_order_status($id)
{
    $order = Order::find($id);
    if($order)
        {
            $order->update(['status'=>$request->status]);
            return response()->json('status changed succefully');
        }else
        return response()->json('order was not found');
}



}