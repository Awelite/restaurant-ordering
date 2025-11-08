<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'assigned_to',
        'status',
        'payment_method',
        'address',
        'address_lat',
        'address_lng',
        'phone',
        'notes',
        'total_amount',
    ];

    public function user()
{
    return $this->belongsTo(User::class);
}

public function orderItems()
{
    return $this->hasMany(OrderItem::class);
}

 public function delivery()
    {
        return $this->hasOne(Delivery::class);
    }
}
