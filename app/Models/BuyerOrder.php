<?php

namespace App\Models;

use App\Models\BuyerProfile;
use App\Models\SupplierProfile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class BuyerOrder extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'grand_total_price' => 'decimal:2',
        'date_of_initial_contact' => 'date',

        // Tells Eloquent to automatically cast these JSON fields to clean PHP arrays
        'quotation_items' => 'array',
        'payment_meta' => 'array',
    ];

    /**
     * Get the parent buyer profile that primarily owns this quotation request.
     */
    public function buyer(): BelongsTo
    {
        return $this->belongsTo(BuyerProfile::class, 'buyer_profile_id');
    }

    /**
     * Relationship: Get the complete communication/negotiation tracker trail for this quote.
     */
    public function trackers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(BuyerOrderTracker::class, 'buyer_order_id');
    }
}
