<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CategoryStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
            'background_image' => ['required', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
            'icon_image' => ['required', 'image', 'max:5120',],
            'icon' => ['required', 'string', 'max:255'],
            'display_at_home' => ['required', 'boolean'],
            'status' => ['required', 'boolean'],
        ];
    }
}
