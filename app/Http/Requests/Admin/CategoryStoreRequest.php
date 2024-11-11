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
            'background_image' => ['required', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
            'icon' => ['required', 'image', 'mimes:jpg,jpeg,png,gif', 'max:5120',],
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
            'display_at_home' => ['required', 'boolean'],
            'status' => ['required', 'boolean'],
        ];
    }
}
