<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->paginate(20);
        return response()->json($orders , 200);
    }
    public function show ()
    {
        $order=Order::find('id');
        return response()->json($order , 200 );
    }

}
