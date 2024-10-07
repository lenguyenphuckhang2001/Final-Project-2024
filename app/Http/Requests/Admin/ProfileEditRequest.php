<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProfileEditRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'avatar' => ['nullable', 'image', 'max:2000'],
            'banner' => ['nullable', 'image', 'max:2000'],
            'fullname' => ['required', 'max:255'],
            'phonenumber' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'address' => ['required', 'max:255'],
            'website' => ['nullable', 'url'],
            'about' => ['nullable', 'max:255'],
            'fb-url' => ['nullable', 'url'],
            'x-url' => ['nullable', 'url'],
            'linked-url' => ['nullable', 'url'],
            'insta-url' => ['nullable', 'url'],
        ];
    }
}
