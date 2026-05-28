<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupplierProfile extends Model {
    const STATUS_UNVERIFIED = 'Unverified Supplier';
    const STATUS_VERIFIED   = 'Verified Supplier';

    protected $guarded = ['id'];

    protected $casts = [
        'ability_to_provide_samples' => 'boolean',
        'date_of_initial_contact'    => 'date',
        'declares_gmo_free'          => 'boolean',
        'declares_gluten_free'        => 'boolean',
        'declares_non_irradiated'    => 'boolean',
        'declares_no_nanomaterials'  => 'boolean',
        'complies_haccp_gmp'         => 'boolean',
    ];

    /**
     * Get the core account access user entry.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Fetch all items listed under this supplier's product inventory catalog.
     */
    public function products(): HasMany
    {
        return $this->hasMany(SupplierProduct::class);
    }
}
