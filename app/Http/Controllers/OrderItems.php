<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderItems extends Controller
{
    protected $fillable =
    [
        'order_id',
        'product_id',
        'price',
        'quantity',
    ];
    public function order()
    {
        $this->belongsTo(Order::class,'order_id');
    }

     public function product()
    {
        $this->belongsTo(Product::class,'product_id');
    }
}
