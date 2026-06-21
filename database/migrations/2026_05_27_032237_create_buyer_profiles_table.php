<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('buyer_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            // $table->integer('user_id')->nullable();
            $table->string('buyer_ref_number')->unique(); // Unique permanent identifier [cite: 160]

            $table->string('status_label')->default('Unprocessed Buyer');
            $table->string('company_icon_path')->nullable(); // [cite: 235]
            $table->json('social_media')->nullable(); // [cite: 242]

            // 1. BUYER COMPANY INFORMATION [cite: 93]
            $table->string('company_name'); // [cite: 94]
            $table->string('company_registration_number')->nullable(); // [cite: 95]
            $table->string('vat_tax_id_number')->nullable(); // [cite: 96]
            $table->string('nature_of_business')->nullable(); // [cite: 97]
            $table->string('company_website')->nullable(); // [cite: 98]
            $table->string('country_of_registration'); // [cite: 99]
            $table->integer('year_established')->nullable(); // [cite: 100]

            // 6. DOCUMENTATION ATTACHMENTS (File storage links unique to this specific order) [cite: 145]
            $table->json('file_sales_contract')->nullable(); // [cite: 147]
            $table->json('file_commercial_invoice')->nullable(); // [cite: 148]
            $table->json('file_packing_list')->nullable(); // [cite: 151]
            $table->json('file_certificate_of_origin')->nullable(); // [cite: 152]
            $table->json('file_test_analysis_report')->nullable(); // [cite: 152]
            $table->json('file_bill_of_lading')->nullable(); // [cite: 152]
            $table->json('file_insurance_certificate')->nullable(); // [cite: 153]
            $table->json('file_product_spec_sheet')->nullable(); // [cite: 154]
            $table->json('file_others')->nullable(); // [cite: 156]

            $table->string('password')->default(Hash::make('glutobuyer')); // Temporary storage for initial password setup, to be hashed and cleared after use [cite: 248]
            // 2. AUTHORIZED REPRESENTATIVE DETAILS [cite: 101]
            $table->string('rep_full_name'); // [cite: 102]
            $table->string('rep_position'); // [cite: 103]
            $table->string('rep_nationality')->nullable(); // [cite: 104]
            $table->string('rep_id_passport_number')->nullable(); // [cite: 105]
            $table->string('rep_mobile_whatsapp'); // [cite: 106]
            $table->string('rep_email'); // [cite: 107]
            $table->text('office_address')->nullable(); // [cite: 108]

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buyer_profiles');
    }
};
