<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('buyer_orders', function (Blueprint $table) {
            $table->id();

            // 1. HARD SYSTEM RELATIONSHIP SHAKING LINKS
            $table->foreignId('buyer_profile_id')->constrained('buyer_profiles')->onDelete('cascade');
            $table->foreignId('supplier_profile_id')->nullable()->constrained('supplier_profiles')->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');

            // 2. TRANSACTION PIPELINE METADATA
            $table->string('order_progress')->default('Unprocessed order');
            $table->string('order_ref_number')->unique();
            $table->string('prod_ref');

            // 3. CORE MATERIAL PARAMETERS
            $table->text('product_names');
            $table->text('product_descriptions')->nullable();
            $table->string('product_origin')->nullable();
            $table->text('packaging_details')->nullable();
            $table->decimal('order_quantity', 15, 2)->default(0.00);
            $table->decimal('quoted_price_per_unit', 15, 4)->default(0.0000);
            $table->decimal('total_order_price', 15, 2)->default(0.00);
            $table->string('quotation_currency', 3)->default('USD');
            $table->text('payment_term_condition')->nullable();
            $table->string('preferred_payment_method')->nullable();
            $table->string('estimated_monthly_volume')->nullable();
            $table->string('shipment_status')->default('unshipped');

            // 4. LOGISTICAL DROPOFF DETAILS
            $table->string('loading_port')->nullable();
            $table->string('destination_country');
            $table->string('destination_port_airport')->nullable();
            $table->text('delivery_address_warehouse')->nullable();
            $table->string('lead_time')->nullable();
            $table->string('preferred_shipping_method')->nullable();
            $table->string('incoterms_preferred')->nullable();

            // Structured array cache column for dynamic multi-part file uploads
            $table->json('payment_meta')->nullable();

            // 5. CRM BACK-OFFICE TRACKING LOGS
            $table->string('assigned_manager')->nullable(); // Legacy legacy fallback text name field
            $table->string('lead_source')->nullable();
            $table->date('date_of_initial_contact')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buyer_orders');
    }
};
