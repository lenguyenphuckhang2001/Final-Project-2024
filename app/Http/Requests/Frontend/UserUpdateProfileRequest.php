<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateProfileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
            'name' => ['required', 'max:255'],
            'phonenumber' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'address' => ['required', 'max:255'],
            'website' => ['nullable', 'url'],
            'about' => ['nullable', 'max:255'],
            'fb_url' => ['nullable', 'url'],
            'x_url' => ['nullable', 'url'],
            'linked_url' => ['nullable', 'url'],
            'insta_url' => ['nullable', 'url'],
        ];
    }
}