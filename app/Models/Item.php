<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['productId', 'product', 'quantity',  'total', 'unit_price'];
}
