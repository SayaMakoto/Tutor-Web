<?php

namespace App\Http\Requests\Admin\Grade;

use Illuminate\Foundation\Http\FormRequest;

class StoreGradeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // sau này check admin ở đây
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ];
    }
}