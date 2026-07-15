<?php

namespace App\Http\Requests\Frontend\ClassRequest;

use Illuminate\Foundation\Http\FormRequest;

class FilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'nullable|integer',
            'status' => 'nullable|in:' . implode(',', array_keys(\App\Models\ClassRequest::statusOptions())),
            'study_type' => 'nullable|in:online,offline',
        ];
    }
}