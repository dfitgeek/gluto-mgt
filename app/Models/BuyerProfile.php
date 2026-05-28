<?php

namespace App\Models;

use App\Models\BuyerOrder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BuyerProfile extends Model
{
    protected $guarded = ['id'];
    //

    public function orders(): HasMany
    {
        return $this->hasMany(BuyerOrder::class);
    }

    /**
     * Helper to instantly get their latest order profile status
     */
    public function currentStatus()
    {
        return $this->orders()->latest()->first()?->profile_label ?? 'Unprocessed Buyer'; // [cite: 91]
    }
}
