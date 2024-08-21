<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_sku',
     'product_name',
      'product_price',
       'product_category',
        'product_description',
         'product_qty'
        ];
}
