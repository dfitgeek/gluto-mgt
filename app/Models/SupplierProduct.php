<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupplierProduct extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'pcs_per_case'     => 'integer',
        'cases_per_pallet' => 'integer',
        'pcs_per_pallet'   => 'integer',
        'price_pieces_usd' => 'decimal:4',
    ];

    /**
     * Relate back up to the master profile context.
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(SupplierProfile::class);
    }
}
