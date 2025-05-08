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
        'status',
    ];

    public $timestamps = true; // Nếu bạn không sử dụng timestamps (created_at, updated_at)
}
