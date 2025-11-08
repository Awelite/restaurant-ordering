<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    public function order()
{
    return $this->belongsTo(Order::class);
}

public function deliveryBoy()
{
    return $this->belongsTo(User::class, 'delivery_boy_id');
}

}
