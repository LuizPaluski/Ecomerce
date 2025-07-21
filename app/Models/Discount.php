<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Discount extends Model
{
    protected $fillable =
        [
            "description",
            "startDate",
            "endDate",
            "discountPercentage",
            "product_id",
        ];

    public function product(): BelongsTo{
        return $this->belongsTo(Product::class);
    }
}
