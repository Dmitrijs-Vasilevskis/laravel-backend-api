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
        Schema::create('quote_address', function (Blueprint $table) {
            $table->id('address_id'); // Primary key
            $table->unsignedBigInteger('quote_id'); // Foreign key to quotes table
            $table->unsignedBigInteger('customer_id')->nullable(); // Foreign key to customers table
            $table->string('email');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('street');
            $table->string('city');
            $table->string('region')->nullable();
            $table->string('postcode');
            $table->string('country_code');
            $table->string('telephone');
            $table->boolean('same_as_billing')->default(false);
            $table->string('shipping_method')->nullable();
            $table->string('shipping_description')->nullable();
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('subtotal_with_discount', 12, 2)->default(0);
            $table->decimal('shipping_amount', 12, 2)->default(0);
            $table->decimal('discount_amount', 12, 2)->default(0);
            $table->decimal('grand_total', 12, 2)->default(0);
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
        Schema::dropIfExists('quote_addresses');
    }
};
