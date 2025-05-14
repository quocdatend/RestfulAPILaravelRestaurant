<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'order_id',
        'user_id',
        'total_price',
        'num_people',
        'special_request_id',
        'customer_name',
        'order_date',
        'order_time',
        'party_id',
        'phone_number',
        'status',
    ];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function party()
    {
        return $this->belongsTo(Party::class, 'party_id');
    }
}
