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
    ];

    /**
     * Get the parent buyer profile that owns this order configuration.
     */
    public function buyer(): BelongsTo
    {
        return $this->belongsTo(BuyerProfile::class);
    }
}
