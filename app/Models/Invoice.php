<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Invoice extends Model
{
    protected $table = 'invoices';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;
    protected $fillable = [
        'id',
        'user_id',
        'order_ref',
        'amount',
        'bank_code',
        'card_type',
        'order_info',
        'pay_date',
        'transaction_no',
        'status'
    ];
    // public function up()
    // {
    //     Schema::create('invoices', function (Blueprint $table) {
    //         $table->id();
    //         $table->string('order_ref');
    //         $table->integer('amount');
    //         $table->string('bank_code');
    //         $table->string('card_type');
    //         $table->string('order_info');
    //         $table->string('pay_date');
    //         $table->string('transaction_no');
    //         $table->string('status');
    //         $table->timestamps();
    //     });
    // }

}
