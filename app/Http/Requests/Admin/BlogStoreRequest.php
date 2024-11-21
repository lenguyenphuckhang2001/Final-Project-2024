<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BlogStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'thumbnail' => ['required', 'image', 'max:10240'],
            'image' => ['required', 'image', 'max:10240'],
            'topic' => ['required', 'integer'],
            'title' => ['required', 'max:255', 'unique:blogs,title'],
            'content' => ['required'],
            'status' => ['required', 'boolean']
        ];
    }
}
