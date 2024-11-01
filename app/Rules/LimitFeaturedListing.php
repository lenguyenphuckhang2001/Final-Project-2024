<?php

namespace App\Rules;

use App\Models\Listing;
use Auth;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class LimitFeaturedListing implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $limitOfFeaturedListings = Auth::user()->membership->package->limit_featured_listing;
        $userListingCount = Listing::where(['user_id' => Auth::user()->id, 'status' => 1, 'is_featured' => 1])->count();

        if ($limitOfFeaturedListings === -1) {
            return;
        }

        if ($userListingCount >= $limitOfFeaturedListings) {
            $fail("You reached maximum of $limitOfFeaturedListings featured listing");
        }
    }
}
