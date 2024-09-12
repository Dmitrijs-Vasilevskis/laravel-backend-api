<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductEntity extends Model
{
    use HasFactory;

    protected $table = 'product_entity';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sku',
        'title',
        'url_key',
        'category',
        'price',
        'discountPercentage',
        'stock',
        'thumbnail'
    ];
}
