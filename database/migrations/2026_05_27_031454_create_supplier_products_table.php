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
        Schema::create('supplier_products', function (Blueprint $table) {
            $table->id();

            // Link to the parent supplier profile
            $table->foreignId('supplier_profile_id')->constrained()->onDelete('cascade');

            // Product Information Table Fields
            $table->string('product_name'); //
            $table->text('product_description')->nullable(); // Info, Language, Origin
            $table->string('ean_upc_code')->nullable(); // Barcode tracking
            $table->integer('pcs_per_case')->default(0); //
            $table->integer('cases_per_pallet')->default(0); //
            $table->integer('pcs_per_pallet')->default(0); //
            $table->string('full_truckload_details')->nullable(); // Logistics data
            $table->string('shelf_life')->nullable(); //
            $table->decimal('price_pieces_usd', 15, 4)->default(0.0000); // Unit valuation grid

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_products');
    }
};
