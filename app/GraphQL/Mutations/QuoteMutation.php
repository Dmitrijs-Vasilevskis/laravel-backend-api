<?php

namespace App\GraphQL\Mutations;

use App\Models\Quote\Quote;
use App\Models\Quote\QuoteAddress;
use App\Models\Quote\QuoteItem;
use App\Services\QuoteService;

class QuoteMutation
{

    protected $quoteService;

    public function __construct(QuoteService $quoteService)
    {
        $this->quoteService = $quoteService;
    }

    public function createQuote($_, array $args) {
        return $this->quoteService->createQuote($args['input']);
    }
}
