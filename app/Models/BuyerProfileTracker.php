<?php

namespace App\Models;

use App\Models\BuyerProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BuyerProfileTracker extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'flagged_fields_or_docs' => 'array',
        'is_internal_only' => 'boolean',
    ];

    /**
     * Get the corporate supplier profile this tracker interaction log belongs to.
     */
    public function supplierProfile(): BelongsTo
    {
        return $this->belongsTo(BuyerProfile::class, 'buyer_profile_id');
    }

    /**
     * Get the specific user (Admin staff or Supplier user) who authored this interaction log.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
