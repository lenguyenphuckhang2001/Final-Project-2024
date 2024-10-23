<?php

namespace App\Rules;

use App\Models\Listing;
use App\Models\Subscription;
use Auth;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class LimitAmenities implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $limitOfPackageAmenities = Auth::user()->subscription->package->limit_amenities;
        if (count($value) >= $limitOfPackageAmenities) {
            $fail("You reached maximum of $limitOfPackageAmenities amenities");
        }
    }
}
