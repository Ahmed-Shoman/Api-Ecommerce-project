<?php

namespace App\Models;

use App\Http\Controllers\OrderItems;
use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'location_id',
        'total_price',
        'date of delivery',
        'status',
    ];

    public function user (){
        return $this->belongsTo(User::class);
    }


    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function orderItems(){
        return $this->hasMany(OrderItems::class);
    }

    public function products(){
        return $this->belongsToMany(product::class);
    }

}