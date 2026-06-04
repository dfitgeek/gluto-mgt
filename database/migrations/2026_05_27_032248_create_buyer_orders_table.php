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
        Schema::create('buyer_orders', function (Blueprint $table) {
            $table->id();

            // Relationship link back to the parent buyer profile
            $table->foreignId('buyer_profile_id')->constrained()->onDelete('cascade');

            // Transaction-Specific Status Label [cite: 46, 56, 91]
            // Allowed: Unprocessed Buyer, Processed Buyer, Confirmed Order, Processing Order, Shipped Order, Completed Order [cite: 91, 92]
            $table->string('profile_label')->default('Unprocessed Buyer'); // [cite: 91]

            // 3. ORDER INFORMATION [cite: 109]
            $table->text('product_names'); // [cite: 110]
            $table->text('product_descriptions')->nullable(); // [cite: 111]
            $table->string('product_origin')->nullable(); // [cite: 112]
            $table->text('packaging_details')->nullable(); // [cite: 113]
            $table->decimal('order_quantity', 15, 2)->default(0.00); // [cite: 114]
            $table->decimal('quoted_price_per_unit', 15, 4)->default(0.0000); // [cite: 115]
            $table->decimal('total_order_price', 15, 2)->default(0.00); // [cite: 116]
            $table->string('quotation_currency', 3)->default('USD'); // [cite: 117]
            $table->text('payment_term_condition')->nullable(); // [cite: 118]
            $table->string('preferred_payment_method')->nullable(); // MT103 TT, Crypto, Bank Transfer [cite: 120, 121, 122]
            $table->string('estimated_monthly_volume')->nullable(); // [cite: 124]

            // 4. SHIPPING & DESTINATION DETAILS [cite: 125]
            $table->string('loading_port')->nullable(); // [cite: 125]
            $table->string('destination_country'); // [cite: 126]
            $table->string('destination_port_airport')->nullable(); // [cite: 127]
            $table->text('delivery_address_warehouse')->nullable(); // [cite: 128]
            $table->string('lead_time')->nullable(); // [cite: 129]
            $table->string('preferred_shipping_method')->nullable(); // Sea Freight, Air Freight, Land Transport [cite: 133, 134, 135]
            $table->string('incoterms_preferred')->nullable(); // FOB, CIF, EXW, DDP [cite: 139, 140, 142, 143]

            // 6. DOCUMENTATION ATTACHMENTS (File storage links unique to this specific order) [cite: 145]
            $table->string('file_sales_contract')->nullable(); // [cite: 147]
            $table->string('file_commercial_invoice')->nullable(); // [cite: 148]
            $table->string('file_packing_list')->nullable(); // [cite: 151]
            $table->string('file_certificate_of_origin')->nullable(); // [cite: 152]
            $table->string('file_test_analysis_report')->nullable(); // [cite: 152]
            $table->string('file_bill_of_lading')->nullable(); // [cite: 152]
            $table->string('file_insurance_certificate')->nullable(); // [cite: 153]
            $table->string('file_product_spec_sheet')->nullable(); // [cite: 154]
            $table->string('file_others')->nullable(); // [cite: 156]

            // 7. MANAGEMENT FOLLOW-UP LOG & TRANSACTION TRACKER [cite: 158]
            $table->string('assigned_manager')->nullable(); // [cite: 161]
            $table->string('lead_source')->nullable(); // [cite: 162]
            $table->date('date_of_initial_contact')->nullable(); // [cite: 163]
            $table->text('buyer_tracker_notes')->nullable(); // Internal logs tracking this specific deal's progress [cite: 47, 57]

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
