<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
    public function up(): void
    {
        Schema::create('buyer_orders', function (Blueprint $table) {
        $table->id();

        // Core Ownership Link
        $table->foreignId('buyer_profile_id')->constrained('buyer_profiles')->onDelete('cascade');

        // Pipeline Progress Tracking Parameters
        $table->string('order_progress')->default('Unprocessed order');
        $table->string('shipment_status')->default('unshipped');
        $table->string('order_ref_number')->unique(); // Unique quotation ticket reference

        // ======================================================================
        // MULTI-ITEM QUOTATION JSON DECK
        // This column stores the array of items requested by the buyer.
        // Structure per item array entry:
        // [
        // 'product_name' => 'Custom input',
        // 'product_description' => '...',
        // 'product_origin' => '...',
        // 'packaging_details' => '...',
        // 'order_quantity' => 5000.00,
        // 'quoted_price_per_unit' => 12.5000,
        // 'total_item_price' => 62500.00,
        // 'payment_term_condition' => '...'
        // ]
        // ======================================================================
        $table->json('quotation_items');

        // Consolidated Financial Summary Metrics
        $table->decimal('grand_total_price', 15, 2)->default(0.00); // sum of all total_item_price values
        $table->string('quotation_currency', 3)->default('USD');
        $table->string('estimated_monthly_volume')->nullable();

        // Logistical Destination Matrix
        $table->string('loading_port')->nullable();
        $table->string('destination_country');
        $table->string('destination_port_airport')->nullable();
        $table->text('delivery_address_warehouse')->nullable();
        $table->string('lead_time')->nullable();
        $table->string('preferred_shipping_method')->nullable();
        $table->string('incoterms_preferred')->nullable();

        // Document Vault (Global compliance sheets, Admin Invoices, Buyer Receipts)
        $table->json('payment_meta')->nullable();

        // Administrative Meta Reference Tracking
        $table->string('assigned_manager')->nullable(); // Plain text name or tracking identifier
        $table->string('lead_source')->nullable();
        $table->date('date_of_initial_contact')->nullable();

        $table->timestamps();
        });
    }

    public function down(): void
    {
    Schema::dropIfExists('buyer_orders');
    }
};
