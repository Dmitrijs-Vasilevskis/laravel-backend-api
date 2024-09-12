<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quote_item', function (Blueprint $table) {
            $table->id('item_id'); // Primary key
            $table->unsignedBigInteger('quote_id'); // Foreign key to quotes table
            $table->unsignedBigInteger('product_id'); // Foreign key to product_entity table
            $table->string('sku');
            $table->string('name');
            $table->float('weight')->default(0);
            $table->integer('qty')->default(1);
            $table->decimal('price', 12, 2)->default(0);
            $table->float('discount_percent')->default(0);
            $table->decimal('discount_amount', 12, 2)->default(0);
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('quote_id')->references('entity_id')->on('quote')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_items');
    }
};
