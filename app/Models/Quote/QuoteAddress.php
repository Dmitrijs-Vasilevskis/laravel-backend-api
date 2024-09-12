<?php

namespace App\Models\Quote;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteAddress extends Model
{
    use HasFactory;

    protected $table = 'quote_address';

    protected $primaryKey = 'address_id';

    protected $fillable = [
        'quote_id',
        'customer_id',
        'email',
        'firstname',
        'lastname',
        'street',
        'city',
        'region',
        'postcode',
        'country_code',
        'telephone',
        'same_as_billing',
        'shipping_method',
        'shipping_description',
        'subtotal',
        'subtotal_with_discount',
        'shipping_amount',
        'discount_amount',
        'grand_total',
    ];

    public function quote()
    {
        return $this->belongsTo(Quote::class, 'quote_id');
    }
}
