<?php

namespace App\GraphQL\Queries;

use App\Models\Quote\Quote;
use App\Models\Quote\QuoteItem;
use App\Models\Quote\QuoteAddress;
use App\Services\QuoteService;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Execution\ResolveInfo;

class QuoteResolver {

    protected $quoteService;

    public function __construct(QuoteService $quoteService)
    {
        $this->quoteService = $quoteService;
    }

    public function getActiveQuoteByCustomerId($root, array $args, GraphQLContext $context, ResolveInfo $info)
    {
       return $this->quoteService->getActiveQuoteByCustomerId($args['customer_id']);
    }
}
