<?php

namespace App\GraphQL\Queries;

use App\Models\ProductEntity;
use App\Models\ProductAttributeEntity;
use App\Models\ProductAttributeValue;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\Facades\Log;
use Nuwave\Lighthouse\Execution\ResolveInfo;

/**
 * CatalogResolver class
 */
class CatalogResolver
{
    public function __construct() {}

    /**
     * @param [type] $root
     * @param array $args
     * @param GraphQLContext $context
     * @param ResolveInfo $info
     * @return void
     */
    public function getAllProducts($root, array $args, GraphQLContext $context, ResolveInfo $info)
    {
        $perPage = $args['first'] ?? 20;
        $page = $args['page'] ?? 1;

        $products = ProductEntity::paginate($perPage, ['*'], 'page', $page);

        // Ensure that data is never null
        if ($products->isEmpty()) {
            $products->setCollection(collect([]));
        }

        // Check if attributes are requested in query
        // to avoid redurant request to database
        $fields = $info->getFieldSelection($depth = 1);

        if (isset($fields['products']['productAttributes'])) {
            foreach ($products->items() as $item) {
                $item['productAttributes'] = $this->getProductWithAttributes($item['id']);
            }
        }

        // Return data in the expected format
        return [
            'products' => $products->items(),
            'paginatorInfo' => [
                'currentPage' => $products->currentPage(),
                'lastPage' => $products->lastPage(),
                'perPage' => $products->perPage(),
                'total' => $products->total(),
                'hasMorePages' => $products->hasMorePages(),
            ],
        ];
    }

    /**
     * @param [type] $root
     * @param [type] $args
     * @return void
     */
    public function getProduct($root, $args)
    {
        // Define the search conditions in a prioritized order
        $conditions = [
            'id' => $args['id'] ?? null,
            'url_key' => $args['url_key'] ?? null,
            'sku' => $args['sku'] ?? null,
        ];

        // Remove null values from the conditions array
        $conditions = array_filter($conditions);

        if (!empty($conditions)) {
            // Fetch the product along with its attributes using eager loading
            $product = ProductEntity::where($conditions)->first();
            $product['productAttributes'] = $this->getProductWithAttributes($product['id']);

            return $product;
        }

        return null;
    }

    /**
     * @param [type] $root
     * @param array $args
     * @param GraphQLContext $context
     * @param ResolveInfo $info
     * @return void
     */
    public function getProductsByCategory($root, array $args, GraphQLContext $context, ResolveInfo $info)
    {
        $perPage = $args['first'] ?? 20;
        $page = $args['page'] ?? 1;
        $category = $args['category'];

        // Fetching products by category and only then apply filtering by paginate
        $productByCategory = ProductEntity::where('category', $category);
        $products = $productByCategory->paginate($perPage, ['*'], 'page', $page);

        // Ensure that data is never null
        if ($products->isEmpty()) {
            $products->setCollection(collect([]));
        }

        // Check if attributes are requested in query
        // to avoid redurant request to database
        $fields = $info->getFieldSelection($depth = 1);

        if (isset($fields['products']['productAttributes'])) {
            foreach ($products->items() as $item) {
                $item['productAttributes'] = $this->getProductWithAttributes($item['id']);
            }
        }

        // Return data in the expected format
        return [
            'products' => $products->items(),
            'paginatorInfo' => [
                'currentPage' => $products->currentPage(),
                'lastPage' => $products->lastPage(),
                'perPage' => $products->perPage(),
                'total' => $products->total(),
                'hasMorePages' => $products->hasMorePages(),
            ],
        ];
    }

    /**
     * @param [type] $productId
     * @return void
     */
    public function getProductWithAttributes($productId)
    {
        return ProductAttributeValue::where('product_id', $productId)->get();
    }

    public function getProductsById($root, array $args, GraphQLContext $context, ResolveInfo $info)
    {
        $productIds = $args['productIds'];

        Log::debug($productIds);

        return ProductEntity::whereIn('id', $productIds)->get();
    }
}
