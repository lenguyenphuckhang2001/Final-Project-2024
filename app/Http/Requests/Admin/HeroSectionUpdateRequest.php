<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class HeroSectionUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'background' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
            'title' => ['required', 'max:255'],
            'sub_title' => ['required']
        ];
    }
}
