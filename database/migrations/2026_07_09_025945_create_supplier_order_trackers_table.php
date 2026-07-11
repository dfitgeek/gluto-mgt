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
        Schema::create('supplier_order_trackers', function (Blueprint $table) {
            $table->id();

            // Relationships
            $table->foreignId('supplier_profile_id')->nullable()->constrained('supplier_profiles')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade'); // The user who sent the note (Admin or Supplier Account)

            // Interaction Metadata Context
            $table->string('subject')->default('General Note'); // e.g., 'Document Rejection', 'Clarification Request', 'General Note', 'System Update'
            $table->text('message_content');

            // Payload Flag Arrays: Tracks exactly which files need structural changes or are unsubmitted
            // Stored natively as clean JSON arrays (e.g., ["file_sales_contract", "file_packing_list"])
            $table->json('flagged_fields_or_docs')->nullable();

            // Action Item Management Engine Lifecycle
            $table->string('resolution_status')->default('Info Only'); // 'Pending Response', 'Resolved', 'Info Only'
            $table->boolean('is_internal_only')->default(false); // True if only Admins should see this note, False if shared with the supplier

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_order_trackers');
    }
};
