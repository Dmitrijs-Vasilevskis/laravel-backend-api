<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Storage;
use App\Models\Categories;
use App\Models\Product;
use App\Models\ProductAttributeEntity;
use App\Models\ProductAttributeValue;
use App\Models\ProductEntity;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
    }

    public function importCategoriesFromJson()
    {
        $categories = Storage::json('./database/migration/categories.json');

        foreach ($categories as $category) {
            // Categories::create(
            //     [
            //         'category_code' => $category['slug'],
            //         'category_title' => $category['name']
            //     ]
            // );
        }
    }

    public function importProductsFromJson()
    {
        $products = Storage::json('./database/migration/products.json');
        $productAttributesEntities = ProductAttributeEntity::all();


        foreach ($products['products'] as $product) {
            $isProductExist = !!Product::where('sku', $product['sku'])->first();
            $productUrlKey = str_replace(' ', '-', strtolower($product['title']));

            // Product::create([
            //     'title' => $product['title'],
            //     'sku' => $product['sku'],
            //     'url_key' => $productUrlKey,
            //     'category' => $product['category'],
            //     'price' => $product['price'],
            //     'discountPercentage' => $product['discountPercentage'],
            //     'stock' => $product['stock'],
            //     'thumbnail' => $product['thumbnail']
            // ]);

            $productId = Product::where('sku', $product['sku'])->pluck('id')->first();

            foreach ($productAttributesEntities as $productAttributeEntity) {
                $id = $productAttributeEntity->id;
                $code = $productAttributeEntity->attribute_code;

                if (isset($product[$code])) {
                    if (is_array($product[$code])) {
                        foreach ($product[$code] as $arrayAttribute) {
                            // ProductAttributeValue::create([
                            //     'attribute_entity_id' => $id,
                            //     'attribute_code' => $code,
                            //     'product_id' => $productId,
                            //     'attribute_value' => $arrayAttribute
                            // ]);
                        }
                    }
                    if (!is_array($product[$code])) {
                        // ProductAttributeValue::create([
                        //     'attribute_entity_id' => $id,
                        //     'attribute_code' => $code,
                        //     'product_id' => $productId,
                        //     'attribute_value' => $product[$code]
                        // ]);
                    }
                }
            }
        }
    }

    public function importProductAttributesEntityFromJson()
    {
        $attributes = Storage::json('./database/migration/product-attributes-entity.json');

        foreach ($attributes['attributes'] as $attribute) {
            // ProductAttributeEntity::create([
            //     'attribute_code' => $attribute['attribute_code'],
            //     'attribute_title' => $attribute['attribute_title'],
            //     'desc' => $attribute['attribute_title']
            // ]);
        }
    }
}
