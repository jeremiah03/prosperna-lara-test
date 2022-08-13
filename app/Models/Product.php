<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name', 'description', 'price',];

    protected $appends = ['formatted_price'];

    protected function formattedPrice(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => number_format($attributes['price'], 2)
        );
    }
}
