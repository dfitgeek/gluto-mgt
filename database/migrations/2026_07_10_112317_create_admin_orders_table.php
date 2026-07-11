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
        Schema::create('admin_orders', function (Blueprint $table) {
            $table->id();

            // Core Multi-Party Ownership Keys
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // The Admin who placed the order
            $table->foreignId('supplier_profile_id')->constrained('supplier_profiles')->onDelete('cascade'); // The target Supplier

            // Operational Status Tracking Parameters
            $table->string('order_status')->default('Pending Vendor Review'); // Pending Vendor Review, Accepted, Shipped, Completed, Cancelled
            $table->string('shipment_status')->default('Unshipped');
            $table->string('purchase_order_number')->unique(); // e.g., PO-XXXX-YYYY

            // ======================================================================
            // MULTI-ITEM ORDER SPECIFICATIONS JSON DECK
            // Array structure per index node element entry:
            // [
            //    'supplier_product_id' => 12, // Native link to item model row
            //    'product_ref' => 'PROD-ABCD-1234',
            //    'product_name' => 'Organic Whole Wheat Flour',
            //    'order_quantity' => 1500, // Case or piece count allocations
            //    'negotiated_price_per_unit' => 450.0000,
            //    'total_item_price' => 675000.00
            // ]
            // ======================================================================
            $table->json('order_items');

            // Financial Summary Metrics Consolidated Deck
            $table->decimal('grand_total_amount', 15, 2)->default(0.00); // Sum of order_items total prices
            $table->string('currency', 3)->default('NGN');

            // Logistical Freight & Pickup Coordination Matrix
            $table->string('loading_port_origin')->nullable();
            $table->string('destination_warehouse_address');
            $table->string('estimated_delivery_date')->nullable();
            $table->string('shipping_carrier_method')->default('Sea Freight'); // Sea Freight, Land Transport, Air Freight
            $table->string('incoterms_rule')->default('FOB'); // FOB, EXW, CIF, DDP

            // Shared Attachment Vault (Admin Payment Slips, Vendor Proformas, Legal Signoffs)
            $table->json('order_meta')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_orders');
    }
};
