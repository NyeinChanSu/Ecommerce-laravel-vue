<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;

class Order extends Model
{
    protected $fillable = ['customer_id', 'status', 'total', 'currency', 'payment_ref', 'shipping_address'];

    protected $casts = [
        'shipping_address' => 'array',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
