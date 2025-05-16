<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_items'; // Tên bảng trong cơ sở dữ liệu
    protected $fillable = [
        'id',
        'order_id',
        'menu_id',
        'quantity',
        'price',
        'total_price'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'id');
    }
}
