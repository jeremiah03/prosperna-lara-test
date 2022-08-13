<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name', 'description', 'img_thumbnail', 'price',];

    protected $appends = ['formatted_price'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucfirst($value),
        );
    }

    protected function formattedPrice(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => '₱ '.number_format($attributes['price'], 2)
        );
    }
}
