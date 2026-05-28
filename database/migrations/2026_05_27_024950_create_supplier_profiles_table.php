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
        Schema::create('supplier_profiles', function (Blueprint $table) {
            $table->id();

            // Relationships & System Labels
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('supplier_ref_number')->unique(); // Internal Protocol [cite: 292]

            // Status Label: Unverified Supplier, Verified Supplier [cite: 233]
            $table->string('status_label')->default('Unverified Supplier');

            // 1. SUPPLIER COMPANY INFORMATION
            $table->string('company_icon_path')->nullable(); // [cite: 235]
            $table->string('company_name'); // [cite: 236]
            $table->text('address'); // [cite: 237]
            $table->string('phone_telephone'); // [cite: 238]
            $table->string('email_address'); // [cite: 239]
            $table->string('website')->nullable(); // [cite: 240]
            $table->string('whatsapp_contact')->nullable(); // [cite: 241]
            $table->string('social_media')->nullable(); // [cite: 242]
            $table->string('reg_number'); // [cite: 243]
            $table->string('type_of_business'); // e.g., Manufacturer, Wholesaler [cite: 244]
            $table->string('nature_of_business'); // [cite: 245]
            $table->integer('year_established')->nullable(); // [cite: 246]
            $table->text('names_of_board_directors')->nullable(); // [cite: 247]
            $table->string('director_position_title')->nullable(); // [cite: 248]
            $table->string('director_email')->nullable(); // [cite: 249]

            // 2. AUTHORIZED REPRESENTATIVE DETAILS [cite: 251]
            $table->string('rep_legal_name'); // [cite: 252]
            $table->string('rep_position_title'); // [cite: 253]
            $table->string('rep_email'); // [cite: 254]
            $table->string('rep_phone_number'); // [cite: 255]

            // 3. CAPABILITIES & OVERALL COMMERCIAL TERMS [cite: 260]
            $table->string('categorization_of_products')->nullable(); // [cite: 261]
            $table->string('overall_moqs')->nullable(); // Global minimum order quantities [cite: 262]
            $table->text('customization_options')->nullable(); // [cite: 263]
            $table->boolean('ability_to_provide_samples')->default(false); // [cite: 264]
            $table->text('manufacturing_locations')->nullable(); // [cite: 265]
            $table->string('production_capacity')->nullable(); // [cite: 266]
            $table->text('product_manufacturing_certifications')->nullable(); // [cite: 267]
            $table->text('returns_warranty_policy')->nullable(); // [cite: 268]
            $table->string('pricing_structure_type')->nullable(); // e.g., Per Unit, Bulk [cite: 269]
            $table->text('payment_terms')->nullable(); // [cite: 270]
            $table->string('currency_accepted', 3)->default('USD'); // [cite: 271]
            $table->decimal('estimated_shipping_costs', 15, 2)->nullable(); // [cite: 272]
            $table->string('shipping_methods_available')->nullable(); // [cite: 273]

            // 4. GENERAL COMPANY DOCUMENTATION (Paths to file storage) [cite: 274]
            $table->string('file_sales_contract')->nullable(); // [cite: 276]
            $table->string('file_commercial_invoice')->nullable(); // [cite: 277]
            $table->string('file_packing_list')->nullable(); // [cite: 282]
            $table->string('file_certificate_of_origin')->nullable(); // [cite: 283]
            $table->string('file_test_analysis_report')->nullable(); // [cite: 283]
            $table->string('file_bill_of_lading')->nullable(); // [cite: 284]
            $table->string('file_insurance_certificate')->nullable(); // [cite: 285]
            $table->string('file_product_spec_sheet')->nullable(); // [cite: 286]
            $table->string('file_others')->nullable(); // [cite: 288]

            // 5. INTERNAL MANAGEMENT LOG & TRACKER [cite: 290]
            $table->string('assigned_manager')->nullable(); // [cite: 293]
            $table->string('lead_source')->nullable(); // [cite: 294]
            $table->date('date_of_initial_contact')->nullable(); // [cite: 295]
            $table->text('supplier_tracker_notes')->nullable(); // Internal text log panel [cite: 308]

            // 6. COMPLIANCE & LEGAL DECLARATIONS [cite: 369]
            $table->boolean('declares_gmo_free')->default(false); // [cite: 370]
            $table->boolean('declares_gluten_free')->default(false); // [cite: 373]
            $table->boolean('declares_non_irradiated')->default(false); // [cite: 375]
            $table->boolean('declares_no_nanomaterials')->default(false); // [cite: 377]
            $table->boolean('complies_haccp_gmp')->default(false); // [cite: 386]

            // Declaration Sign-off [cite: 390]
            $table->string('declaration_authorized_person')->nullable(); // [cite: 390]
            $table->string('declaration_title')->nullable(); // [cite: 391]
            $table->string('declaration_signature_path')->nullable(); // Image path of signature [cite: 392]

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_profiles');
    }
};
