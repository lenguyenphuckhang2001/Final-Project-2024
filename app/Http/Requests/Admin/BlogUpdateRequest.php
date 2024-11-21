<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BlogUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'thumbnail' => ['nullable', 'image', 'max:10240'],
            'image' => ['nullable', 'image', 'max:10240'],
            'topic' => ['nullable', 'integer'],
            'title' => ['nullable', 'max:255', 'unique:blogs,title,' . $this->blog],
            'content' => ['nullable'],
            'status' => ['required', 'boolean']
        ];
    }
}
