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
        Schema::create('buyer_order_trackers', function (Blueprint $table) {
            $table->id();

            // Direct link to the parent quote or order layout being discussed
            $table->foreignId('buyer_order_id')->constrained('buyer_orders')->onDelete('cascade');

            // Relationships[cite: 7]
            $table->foreignId('buyer_profile_id')->nullable()->constrained('buyer_profiles')->onDelete('cascade'); //[cite: 7]
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade'); // The admin user who sent the note[cite: 7]

            // Interaction Metadata Context[cite: 7]
            $table->string('subject')->default('General Note'); // e.g., 'Pricing Counter', 'Clarification Request', 'General Note'[cite: 7]
            $table->text('message_content'); //[cite: 7]

            // Payload Flag Arrays: Tracks exactly which fields need structural changes or are unsubmitted[cite: 7]
            $table->json('flagged_fields_or_docs')->nullable(); //[cite: 7]

            // Action Item Management Engine Lifecycle[cite: 7]
            $table->string('resolution_status')->default('Info Only'); // 'Pending Response', 'Resolved', 'Info Only'[cite: 7]
            $table->boolean('is_internal_only')->default(false); // True if hidden from the buyer[cite: 7]

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buyer_order_trackers');
    }
};
