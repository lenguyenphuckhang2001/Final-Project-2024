<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chat extends Model
{
    use HasFactory;

    function receiverProfile(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id', 'id')->select(['id', 'name', 'avatar']);
    }

    function listingInfo(): BelongsTo
    {
        return $this->belongsTo(Listing::class, 'listing_id', 'id')->select(['id', 'image', 'title']);
    }
}