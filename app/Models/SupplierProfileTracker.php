<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupplierProfileTracker extends Model
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
        return $this->belongsTo(SupplierProfile::class, 'supplier_profile_id');
    }

    /**
     * Get the specific user (Admin staff or Supplier user) who authored this interaction log.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
