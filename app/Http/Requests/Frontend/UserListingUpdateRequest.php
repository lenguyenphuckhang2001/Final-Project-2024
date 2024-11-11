<?php

namespace App\Http\Requests\Frontend;

use App\Models\Listing;
use App\Rules\LimitFacilities;
use App\Rules\LimitFeaturedListing;
use Auth;
use Illuminate\Foundation\Http\FormRequest;

class UserListingUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * Xác định xem người dùng có được phép thực hiện yêu cầu này hay không.
     */
    public function authorize(): bool
    {
        // Lấy ra trường 'user_id' từ bảng 'listings' nơi 'id' của bản ghi khớp với giá trị 'listing' từ request hiện tại.
        // Chỉ lấy một bản ghi đầu tiên tìm thấy.
        // $this->listing được hiểu là tham số 'listing' trong request mà người dùng gửi.
        $listing = Listing::select('user_id') // Chọn trường 'user_id' từ bảng 'listings'.
            ->where('id', $this->listing) // Lọc các bản ghi có 'id' bằng với giá trị của 'listing' trong request.
            ->first(); // Lấy bản ghi đầu tiên tìm thấy (trả về đối tượng hoặc null nếu không tìm thấy).

        // Kiểm tra xem ID của người dùng hiện tại có bằng với 'user_id' của listing hay không.
        // Auth::user()->id: Lấy ID của người dùng hiện tại từ hệ thống xác thực của Laravel.
        // $listing->user_id: Lấy ID người dùng sở hữu listing (cần sửa để lấy giá trị 'user_id' thay vì đối tượng $listing).
        // Trả về true nếu ID người dùng hiện tại trùng với 'user_id' của listing, ngược lại trả về false.
        return Auth::user()->id === $listing->user_id;
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'image' => ['image', 'mimes:jpg,jpeg,png,gif', 'max:10240'],
            'thumbnail' => ['image', 'mimes:jpg,jpeg,png,gif', 'max:10240'],
            'category' => ['required', 'integer'],
            'location' => ['required', 'integer'],
            'title' => ['required', 'string', 'max:255', 'unique:listings,title,' . $this->listing],
            'phonenumber' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'description' => ['required'],
            'website' => ['nullable', 'url'],
            'fb_url' => ['nullable', 'url'],
            'x_url' => ['nullable', 'url'],
            'linked_url' => ['nullable', 'url'],
            'insta_url' => ['nullable', 'url'],
            'attachment' => ['nullable', 'mimes:jpg,jpeg,png,gif,pdf,doc,docx,xls,xlsx,txt,zip,rar,mp3,mp4,csv', 'max:50000'],
            'facilities.*' => ['nullable', 'integer'],
            'facilities' => [new LimitFacilities],
            'map_embed_code' => ['nullable'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string'],
            'status' => ['required', 'boolean'],
            'is_featured' => ['required', 'boolean'],
            // 'listing' => ['required', new LimitFeaturedListing]
        ];
    }
}
