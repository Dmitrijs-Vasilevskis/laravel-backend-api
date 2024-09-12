<?php

namespace App\GraphQL\Queries;

use App\Models\Product;
use App\Models\ProductEntity;
use App\Models\ProductAttributeEntity;
use App\Models\ProductAttributeValue;
use App\Models\Quote\Quote;
use App\Models\Quote\QuoteItem;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\Facades\Log;
use Nuwave\Lighthouse\Execution\ResolveInfo;

/**
 * CartResolver class
 */
class CartResolver
{

    public function __construct() {}

    public function getCartItems($root, array $args, GraphQLContext $context, ResolveInfo $info)
    {
        $quoteId = $args['quote_id'];

        $quoteItems = QuoteItem::where('quote_id', $quoteId)->get();

        if ($quoteItems->isNotEmpty()) {
            $cartItems = [];
            $productsIds = $quoteItems->pluck('product_id')->toArray();

            $products = ProductEntity::whereIn('id', ($productsIds))->get();

            foreach ($quoteItems as $quoteItem) {
                $product = $products->firstWhere('id', $quoteItem['product_id']);

                if ($product) {
                    $product['qty'] = $quoteItem['qty'];
                    $cartItems[] = $product;
                }
            }

            Log::debug($cartItems);

            return $cartItems;
        }
    }
}
