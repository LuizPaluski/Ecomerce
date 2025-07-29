<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['total'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Calculate the total price of the cart, applying any active discounts.
     *
     * @return float
     */
    public function getTotalAttribute()
    {

        $this->loadMissing('items.product.discounts');

        return $this->items->sum(function ($item) {

            if ($item->product) {

                return $item->product->price_with_discount * $item->quantity;
            }
            return 0;
        });
    }
}
