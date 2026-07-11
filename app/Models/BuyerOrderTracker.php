<?php

namespace App\Models;

use App\Models\BuyerOrder;
use App\Models\BuyerProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BuyerOrderTracker extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'flagged_fields_or_docs' => 'array', //[cite: 7]
        'is_internal_only' => 'boolean', //[cite: 7]
    ];

    /**
     * Relationship: Get the parent quote context being audited or discussed.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(BuyerOrder::class, 'buyer_order_id');
    }

    /**
     * Relationship: The Buyer profile author of the log tracking message (if any).
     */
    public function buyer(): BelongsTo
    {
        return $this->belongsTo(BuyerProfile::class, 'buyer_profile_id');
    }

    /**
     * Relationship: The Administrative user author of the track notification node (if any).
     */
    public function administrator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
