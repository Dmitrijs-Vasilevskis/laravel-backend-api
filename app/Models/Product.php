<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product_entity';

    protected $fillable = [
        'sku',
        'title',
        'category',
        'price',
        'discountPercentage',
        'stock',
        'thumbnail',
    ];
}
