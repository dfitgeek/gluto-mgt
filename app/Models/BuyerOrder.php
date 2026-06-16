<?php

namespace App\Models;

use App\Models\BuyerProfile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BuyerOrder extends Model
{
    //
    protected $guarded = ['id'];

    protected $casts = [
        'order_quantity' => 'decimal:2', // [cite: 114]
        'quoted_price_per_unit' => 'decimal:4', // [cite: 115]
        'total_order_price' => 'decimal:2', // [cite: 116]
        'date_of_initial_contact' => 'date', // [cite: 163]
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
     * Get the parent buyer profile that owns this order configuration.
     */
    public function buyer(): BelongsTo
    {
        return $this->belongsTo(BuyerProfile::class);
    }
}
