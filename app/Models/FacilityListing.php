<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FacilityListing extends Model
{
    use HasFactory;

    function facility(): BelongsTo
    {
        return $this->belongsTo(Facility::class, 'facility_id', 'id');
    }
}
