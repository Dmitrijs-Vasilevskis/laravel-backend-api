<?php

namespace App\Models\Quote;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteItem extends Model
{
    use HasFactory;

    protected $table = 'quote_item';

    protected $primaryKey = 'item_id';

    protected $fillable = [
        'quote_id',
        'product_id',
        'sku',
        'name',
        'weight',
        'qty',
        'price',
        'discount_percent',
        'discount_amount',
    ];

    public function quote()
    {
        return $this->belongsTo(Quote::class, 'quote_id');
    }
}
