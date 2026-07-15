<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupplierProduct extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'product_images' => 'array',
        'ability_to_provide_samples' => 'boolean',
        'price_pieces' => 'decimal:4',
        'pcs_per_case' => 'integer',
        'cases_per_pallet' => 'integer',
        'pcs_per_pallet' => 'integer',
    ];

    /**
     * Relate back up to the master profile context.
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(SupplierProfile::class, 'supplier_profile_id');
    }
}
