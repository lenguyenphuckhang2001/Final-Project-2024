<?php

namespace App\Http\Requests\Frontend;

use App\Rules\LimitFacilities;
use App\Rules\LimitFeaturedListing;
use App\Rules\LimitListings;
use Illuminate\Foundation\Http\FormRequest;

class UserListingStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // public function authorize(): bool
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,gif', 'max:10240'],
            'thumbnail' => ['required', 'image', 'mimes:jpg,jpeg,png,gif', 'max:10240'],
            'category' => ['required', 'integer'],
            'location' => ['required', 'integer'],
            'title' => ['required', 'string', 'max:255', 'unique:listings,title'],
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
            /* Đặt tên cho field và điền vào 2 giá trị required và new (rules muốn áp dụng)
                Sau khi có giá trị thêm vào ở store view nơi khởi tạo các dữ liệu*/
            'listing' => ['required', new LimitListings, new LimitFeaturedListing]
        ];
    }
}
