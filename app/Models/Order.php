<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable =
        [
            'user_id',
            'total_price',
            'total_quantity',
            'status',
        ];

    protected function casts(): array
    {
        return [
            'status' => OrderStatus::class,
        ];
    }
}
