<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ContactUsUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'phonenumber_one' => ['required', 'string', 'max:255'],
            'phonenumber_two' => ['nullable', 'string', 'max:255'],
            'email_one' => ['required', 'email', 'max:255'],
            'email_two' => ['nullable', 'email', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'map_embed_code' => ['required']
        ];
    }
}
