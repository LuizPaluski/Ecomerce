<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['unit_price', 'total_price'];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the price for a single unit of the product, with discount.
     * O 'unit_price' representa o valor de uma unidade do produto, já com o desconto aplicado.
     *
     * @return float|null
     */
    public function getUnitPriceAttribute()
    {
        if ($this->product) {
            // Utiliza o accessor 'price_with_discount' do modelo Product.
            return $this->product->price_with_discount;
        }
        return null;
    }

    /**
     * Get the total price for the cart item (unit price * quantity).
     * O 'total_price' é o preço unitário multiplicado pela quantidade do item no carrinho.
     *
     * @return float|null
     */
    public function getTotalPriceAttribute()
    {
        if ($this->unit_price !== null) {
            return $this->unit_price * $this->quantity;
        }
        return null;
    }
}
