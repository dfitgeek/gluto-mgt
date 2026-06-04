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
        Schema::create('registration_onboarding_tokens', function (Blueprint $table) {
            $table->id();

            // Constrained Relationship linking directly to your primary User model
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            // Secure token parameters string layout mapping
            $table->string('token', 64)->unique();

            // Lifecycle and single-use status parameter slots
            $table->timestamp('expires_at');
            $table->boolean('is_used')->default(false);
            $table->timestamp('used_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registration_onboarding_tokens');
    }
};
