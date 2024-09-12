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
        Schema::create('quote', function (Blueprint $table) {
            $table->id('entity_id'); // Primary key
            $table->boolean('is_active')->default(true);
            $table->integer('items_count')->default(0);
            $table->float('items_qty')->default(0);
            $table->decimal('grand_total', 12, 2)->default(0);
            $table->string('checkout_method')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable(); // Reference to customers
            $table->string('customer_email')->nullable();
            $table->string('customer_firstname')->nullable();
            $table->string('customer_lastname')->nullable();
            $table->boolean('customer_is_guest')->default(false);
            $table->string('coupon_code')->nullable();
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('base_subtotal', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
