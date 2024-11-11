<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StatisticalSectionUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // public function authorize(): bool
    // {
    //     return false;
    // }

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
