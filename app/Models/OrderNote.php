<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderNote extends Model
{
    protected $table = 'order_notes';

    protected $fillable = [
        'order_note_id',
        'note',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public $timestamps = false;
}
