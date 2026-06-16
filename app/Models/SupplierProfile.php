<?php

namespace App\Models;

// 1. REMOVE OR REPLACE THE OLD BASE MODEL IMPORT:
// use Illuminate\Database\Eloquent\Model;

// 2. ADD THE AUTHENTICATABLE USER BASE CLASS IMPORT:
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// 3. CHANGE THE CLASS TO EXTEND THE AUTHENTICATABLE BASE:
class SupplierProfile extends Authenticatable
{
    use Notifiable; // Recommended if suppliers receive system notifications/emails

    const STATUS_UNVERIFIED = 'Unverified Supplier';
    const STATUS_VERIFIED = 'Verified Supplier';

    protected $guarded = ['id'];

    protected $casts = [
        'ability_to_provide_samples' => 'boolean',
        'date_of_initial_contact' => 'date',
        'declares_gmo_free' => 'boolean',
        'declares_gluten_free' => 'boolean',
        'declares_non_irradiated' => 'boolean',
        'declares_no_nanomaterials' => 'boolean',
        'complies_haccp_gmp' => 'boolean',
        'social_media' => 'array',
        'password' => 'hashed', // Handles auto-hashing securely

        // Document vaults array fields
        'file_sales_contract' => 'array',
        'file_commercial_invoice' => 'array',
        'file_packing_list' => 'array',
        'file_certificate_of_origin' => 'array',
        'file_test_analysis_report' => 'array',
        'supplier_invoice' => 'array',
        'proforma_invoice' => 'array',
        'file_bill_of_lading' => 'array',
        'file_insurance_certificate' => 'array',
        'file_product_spec_sheet' => 'array',
        'file_others' => 'array',
        'returns_warranty_policy' => 'array',
        'product_manufacturing_certifications' => 'array',
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * Override default username locator column:
     * Tells Laravel to parse 'rep_email' instead of the standard 'email' string field.
     */
    public function getAuthIdentifierName()
    {
        return 'rep_email';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(SupplierProduct::class);
    }

    public function trackers(): HasMany
    {
        return $this->hasMany(SupplierProfileTracker::class, 'supplier_profile_id')->latest();
    }
}
