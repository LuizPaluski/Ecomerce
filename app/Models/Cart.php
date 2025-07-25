<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    protected $fillable = [
        'address_id',
        'coupon_id',
        ];
    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function Items(): HasMany{
        return $this->hasMany(CartItem::class);
    }

    public function product(): BelongsTo{
        return $this->belongsTo(Product::class);
    }

    public function discounts(): BelongsTo{
        return $this->belongsTo(Discount::class);
    }
}
