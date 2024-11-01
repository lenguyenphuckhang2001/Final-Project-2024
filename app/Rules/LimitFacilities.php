<?php

namespace App\Rules;

use App\Models\Listing;
use App\Models\Membership;
use Auth;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class LimitFacilities implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $limitOfPackageFacilities = Auth::user()->membership->package->limit_facilities;

        if ($limitOfPackageFacilities === -1) {
            return;
        }

        if (count($value) > $limitOfPackageFacilities) {
            $fail("You reached maximum of $limitOfPackageFacilities facilities");
        }
    }
}
