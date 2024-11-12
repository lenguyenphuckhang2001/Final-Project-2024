<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:categories,name,' . $this->category],
            'background_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:10240'],
            'icon_image' => ['nullable', 'image', 'max:5120',],
            'icon' => ['nullable', 'string', 'max:255'],
            'display_at_home' => ['required', 'boolean'],
            'status' => ['required', 'boolean'],
        ];
    }
}
