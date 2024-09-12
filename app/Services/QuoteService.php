<?php

namespace App\Services;

use App\Models\Quote\Quote;
use App\Models\Quote\QuoteAddress;
use App\Models\Quote\QuoteItem;
use Illuminate\Support\Facades\Log;

class QuoteService
{
    public function createQuote($input)
    {
        // Step 1: Create the quote for the customer
        $quote = Quote::create([
            'customer_id' => $input['customer']['customer_id'],
            'customer_firstname' => $input['customer']['customer_firstname'],
            'customer_lastname' => $input['customer']['customer_lastname'],
            'customer_email' => $input['customer']['customer_email'],
            'customer_is_guest' => $input['customer']['customer_is_guest'],
            'grand_total' => 0, // skip at quote initial 
            'items_count' => 0,
            'items_qty' => 0,
            'is_active' => true
        ]);

        $grandTotal = 0;
        $items_count = 0;
        $items_qty = 0;

        // Add item to the quoteItem
        foreach ($input['item'] as $item) {
            if (!is_array($item)) {
                throw new \Exception('Invalid item data');
            }

            $discountAmount = ($item['price'] * $item['discount_percent']) / 100;
            $finalPrice = $item['price'] - $discountAmount;

            QuoteItem::create([
                'quote_id' => $quote->entity_id,
                'product_id' => $item['product_id'],
                'sku' => $item['sku'],
                'name' => $item['title'],
                'qty' => $item['qty'],
                'price' => $item['price'],
                'discount_percent' => $item['discount_percent'],
                'discount_amount' => $discountAmount
            ]);

            $grandTotal += $item['qty'] * $finalPrice;

            $items_count++;
            $items_qty += $item['qty'];
        }


        $quote->items_count += $items_count;
        $quote->items_qty += $items_qty;
        $quote->grand_total = $grandTotal;
        $quote->save();

        return $quote;
    }

    public function addProductToQuote($input)
    {
        $quote = Quote::where('entity_id', $input['entity_id']);
    }

    public function getActiveQuoteByCustomerId($customer_id)
    {
        $quote = Quote::where([
            'is_active' => true,
            'customer_id' => $customer_id
        ]);

        $quote = $quote->first();
        
        return $quote;
    }
}
