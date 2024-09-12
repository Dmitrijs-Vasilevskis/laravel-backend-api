<?php

namespace App\Models\Quote;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    protected $table = 'quote';

    protected $primaryKey = 'entity_id';

    protected $fillable = [
        'is_active',
        'items_count',
        'items_qty',
        'grand_total',
        'checkout_method',
        'customer_id',
        'customer_email',
        'customer_firstname',
        'customer_lastname',
        'customer_is_guest',
        'coupon_code',
        'subtotal',
        'base_subtotal',
    ];

    public function addresses()
    {
        return $this->hasMany(QuoteAddress::class, 'quote_id');
    }

    public function items()
    {
        return $this->hasMany(QuoteItem::class, 'quote_id');
    }
}
