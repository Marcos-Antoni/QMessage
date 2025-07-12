<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    
    protected $fillable = [
        'user_id',
        'status',
        'transaction_id',
    ];

    protected $hidden = [
        'user_id',
        'transaction_id'
    ];
}
