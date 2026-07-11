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
