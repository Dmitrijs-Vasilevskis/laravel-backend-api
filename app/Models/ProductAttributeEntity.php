<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttributeEntity extends Model
{
    use HasFactory;

    protected $table = 'product_attribute_entity';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'attribute_code',
        'attribute_title',
        'desc',
    ];
}
