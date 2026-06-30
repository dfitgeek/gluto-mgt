<?php

namespace App\Models;

use App\Models\BuyerOrder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BuyerProfile extends Authenticatable
{
    use Notifiable;

    protected $guarded = ['id'];

    protected $casts = [
        'social_media' => 'array',
        'password' => 'hashed',
        'company_reg_doc' => 'array',
        'id_card' => 'array',
    ];

    /**
     * SYSTEM KEY LOCATOR:
     * Dictates the return data type format for auth()->id() under the buyer guard.
     */
    public function getAuthIdentifierName()
    {
        return 'id';
    }

    /**
     * LOGIN COLUMN OVERRIDE:
     * Maps authentication checking queries strictly to the rep_email column.
     */
    public function username()
    {
        return 'rep_email';
    }

    public function orders(): HasMany
    {
        return $this->hasMany(BuyerOrder::class);
    }

    /**
     * Helper to instantly get their latest order profile status
     */
    public function currentStatus()
    {
        return $this->orders()->latest()->first()?->profile_label ?? 'Unprocessed Buyer';
    }

    public function trackers(): HasMany
    {
        return $this->hasMany(BuyerProfileTracker::class, 'buyer_profile_id')->latest();
    }
}
