<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    protected $table = 'parties';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'party_id',
        'name',
    ];
}
