<?php

namespace App\GraphQL\Queries;

use App\Models\Categories;

class CategoryResolver
{

    // Get all categories
    public function getAllCategories()
    {
        return Categories::all();
    }

    // Get a single category by ID or category_code
    public function getCategoryByArgs($root, $args)
    {
        if (isset($args['id'])) {
            return Categories::find($args['id']);
        }

        if (isset($args['category_code'])) {
            return Categories::where('category_code', $args['category_code'])->first();
        }

        return null;
    }
}
