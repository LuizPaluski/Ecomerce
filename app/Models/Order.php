<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }
}
