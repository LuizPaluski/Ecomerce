<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function discounts(): HasMany{
        return $this->hasMany(Discount::class);
    }


}
