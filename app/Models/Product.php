<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Discount;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'stock',
        'category_id',
        'description',
        'price',
        'image',
        'discount',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function discounts(): HasMany{
        return $this->hasMany(Discount::class);
    }


}
