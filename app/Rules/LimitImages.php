<?php

namespace App\Rules;

use App\Models\ImageGalerry;
use Auth;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class LimitImages implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $limitOfImages = Auth::user()->subscription->package->limit_photos;
        $imageGalleryCount = ImageGalerry::where('listing_id', $value)->count();
        //Prevent user upload multiple images gallery max
        $userMultiUpload = count(request('images'));

        if ($imageGalleryCount + $userMultiUpload > $limitOfImages) {
            $fail("You reached maximum images can upload");
        }
    }
}