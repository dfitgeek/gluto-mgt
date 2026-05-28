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
        Schema::create('buyer_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('buyer_ref_number')->unique(); // Unique permanent identifier [cite: 160]

            // 1. BUYER COMPANY INFORMATION [cite: 93]
            $table->string('company_name'); // [cite: 94]
            $table->string('company_registration_number')->nullable(); // [cite: 95]
            $table->string('vat_tax_id_number')->nullable(); // [cite: 96]
            $table->string('nature_of_business')->nullable(); // [cite: 97]
            $table->string('company_website')->nullable(); // [cite: 98]
            $table->string('country_of_registration'); // [cite: 99]
            $table->integer('year_established')->nullable(); // [cite: 100]

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
