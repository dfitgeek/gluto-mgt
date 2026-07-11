<?php

namespace App\Models;

use App\Models\SupplierProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminOrder extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'grand_total_amount' => 'decimal:2',

        // Auto serialize arrays frames to JSON database values natively
        'order_items' => 'array',
        'order_meta' => 'array',
    ];

    /**
     * Relationship: The back-office Administrator user who issued the purchase order.
     */
    public function administrator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relationship: The target Supplier fulfilling the contract array payload.
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(SupplierProfile::class, 'supplier_profile_id');
    }

    /**
     * Relationship: Get the complete discussion/negotiation log trail for this supplier purchase order.
     */
    public function trackers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(AdminOrderTracker::class, 'admin_order_id');
    }
}
