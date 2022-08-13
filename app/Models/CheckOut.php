<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckOut extends Model
{
    use HasFactory;

    protected $table = 'checkout';

    protected $fillable = ['user_id', 'address', 'address2', 'country', 'zip', 'payment_method', 'total_amount',];
}
