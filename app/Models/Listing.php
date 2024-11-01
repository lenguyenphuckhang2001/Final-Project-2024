<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Listing extends Model
{
    use HasFactory, SoftDeletes;

    function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    function gallery(): HasMany
    {
        return $this->hasMany(ImageGalerry::class, 'listing_id', 'id');
    }

    function facilities(): HasMany
    {
        return $this->hasMany(FacilityListing::class, 'listing_id', 'id');
    }

    function videos(): HasMany
    {
        return $this->hasMany(VideoGallery::class, 'listing_id', 'id');
    }

    function schedules(): HasMany
    {
        return $this->hasMany(ListingSchedule::class, 'listing_id', 'id');
    }

    function evaluates(): HasMany
    {
        return $this->hasMany(Evaluate::class);
    }
}
