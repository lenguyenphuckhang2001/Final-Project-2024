<?php

namespace App\Rules;

use App\Models\VideoGallery;
use Auth;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class LimitVideos implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $limitOfVideos = Auth::user()->subscription->package->limit_video;
        $userVideoCount = VideoGallery::where('listing_id', $value)->count();

        if ($limitOfVideos === -1) {
            return;
        }

        if ($userVideoCount >= $limitOfVideos) {
            $fail('You reached maximum of videos can upload');
        }
    }
}
