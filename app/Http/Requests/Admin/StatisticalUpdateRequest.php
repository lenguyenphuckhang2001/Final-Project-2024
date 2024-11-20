<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StatisticalUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'background' => ['nullable', 'image', 'max:10240'],

            'title_first' => ['nullable', 'string', ' max:255'],
            'number_first' => ['nullable', 'integer'],

            'title_second' => ['nullable', 'string', ' max:255'],
            'number_second' => ['nullable', 'integer'],

            'title_third' => ['nullable', 'string', ' max:255'],
            'number_third' => ['nullable', 'integer'],

            'title_fourth' => ['nullable', 'string', ' max:255'],
            'number_fourth' => ['nullable', 'integer'],
        ];
    }
}
