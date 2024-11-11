<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ListingUpdateRequest extends FormRequest
{

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
            'facilities.*' => ['integer'],
            'map_embed_code' => ['nullable'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string'],
            'status' => ['required', 'boolean'],
            'is_featured' => ['required', 'boolean'],
            'is_verified' => ['required', 'boolean']
        ];
    }
}
