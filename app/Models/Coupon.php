<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable =
        [
            'code',
            'endDate',
            'startDate',
            'discountPercentage',

        ];

    protected $casts = [
        'discountPercentage' => 'decimal:2',
        'endDate' => 'datetime',
    ];


}
