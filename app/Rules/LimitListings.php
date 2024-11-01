<?php

namespace App\Rules;

use App\Models\Listing;
use Auth;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class LimitListings implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        /** Tạo rules cho chức năng limit listing của package
         * Đầu tiên khởi tạo check user đăng kí gói nào hay có giới hạn nào bằng cách tạo một liên kết giữa user và subcription với quan hệ 1 : 1
         * bởi vì 1 user chỉ sỡ hữu tối đa 1 packages
         *
         * Sau đó tiếp theo query Listing với số listing bằng cách thêm 1 trường where để biết có bao nhiêu packages bằng user_id
         *
         * Viết điều kiện rằng nếu userListingCount( giả sử có 1 ) xem có lớn hơn hoặc bằng limit không (giả sử cho tối đa 2) sau đó nếu vượt quá
         * thì trả về fail('message')
         *
         * Xử lý ở require của store listings
         */
        $limitOfPackageListing = Auth::user()->membership->package->limit_listing;
        $userListingCount = Listing::where(['user_id' => Auth::user()->id, 'status' => 1])->count();

        if ($limitOfPackageListing === -1) {
            return;
        }

        if ($userListingCount >= $limitOfPackageListing) {
            $fail('You reached maximum of ' . $limitOfPackageListing . ' listing');
        }
    }
}
