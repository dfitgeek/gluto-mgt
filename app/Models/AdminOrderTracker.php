<?php

namespace App\Models;


use App\Models\AdminOrder;
use App\Models\SupplierProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminOrderTracker extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'flagged_fields_or_docs' => 'array',
        'is_internal_only' => 'boolean',
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

    /**
     * Relationship: Get the parent administrative purchase order context being discussed.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(AdminOrder::class, 'admin_order_id');
    }

    /**
     * Relationship: The back-office Administrator user who authored this note.
     */
    public function administrator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relationship: The Supplier Profile identity who authored this note (if any).
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(SupplierProfile::class, 'supplier_profile_id');
    }
}
