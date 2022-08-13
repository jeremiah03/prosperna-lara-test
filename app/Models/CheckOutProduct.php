<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckOutProduct extends Model
{
    use HasFactory;

    protected $table = 'checkout_products';

    protected $fillable = ['check_out_id', 'product_id', 'quantity', 'amount'];
}
