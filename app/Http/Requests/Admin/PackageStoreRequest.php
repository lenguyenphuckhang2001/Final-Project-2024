<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PackageStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => ['required', 'in:free,premium'],
            'name' => ['required', 'string', 'max:30', 'unique:packages,name'],
            'price' => ['required', 'numeric'],
            'limit_days' => ['required', 'integer'],
            'limit_listing' => ['required', 'integer'],
            'limit_photos' => ['required', 'integer'],
            'limit_video' => ['required', 'integer'],
            'limit_amenities' => ['required', 'integer'],
            'limit_featured_listing' => ['required', 'integer'],
            'display_at_home' => ['required', 'boolean'],
            'status' => ['required', 'boolean']
        ];
    }

    function messages()
    {
        return [
            'limit_days.required' => 'Limit days field is required',
            'limit_days.integer' => 'Limit days field must be integer',

            'limit_listing.required' => 'Limit listing field is required',
            'limit_listing.integer' => 'Limit listing field must be integer',

            'limit_photos.required' => 'Limit photos field is required',
            'limit_photos.integer' => 'Limit photos field must be integer',

            'limit_video.required' => 'Limit video field is required',
            'limit_video.integer' => 'Limit video field must be integer',

            'limit_amenities.required' => 'Limit amenities field is required',
            'limit_amenities.integer' => 'Limit amenities field must be integer',

            'limit_featured_listing.required' => 'Limit featured listing field is required',
            'limit_featured_listing.integer' => 'Limit featured listing field must be integer',
        ];
    }
}
