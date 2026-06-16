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
            $table->string('product_ref')->unique(); // Redundant for quick reference, can be derived from relationship [cite: 293]
            $table->string('product_category')->nullable(); // Categorical classification for filtering and search (e.g., Gluten, Non-Gluten, Organic) [cite: 272]
            $table->json('product_images')->nullable(); // Array of image paths for product visualization [cite: 273]
            $table->string('production_capacity')->nullable(); // [cite: 266]
            $table->text('payment_terms')->nullable(); // [cite: 270]
            $table->string('overall_moqs')->nullable(); // Global minimum order quantities [cite: 262]
            // Product Information Table Fields
            $table->string('product_name'); //
            $table->boolean('ability_to_provide_samples')->default(false); // [cite: 264]

            $table->text('product_description')->nullable(); // Info, Language, Origin
            $table->string('ean_upc_code')->nullable(); // Barcode tracking
            $table->string('pricing_structure_type')->nullable(); // e.g., Per Unit, Bulk [cite: 269]
            $table->integer('pcs_per_case')->default(0); //
            $table->integer('cases_per_pallet')->default(0); //
            $table->integer('pcs_per_pallet')->default(0); //
            $table->string('full_truckload_details')->nullable(); // Logistics data
            $table->string('product_catalogue')->nullable(); // File

            $table->string('shelf_life')->nullable(); //
            $table->decimal('price_pieces', 15, 4)->default(0.0000); // Unit valuation grid

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
