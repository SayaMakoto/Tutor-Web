<?php

namespace App\Http\Requests\Admin\Subject;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // sau này check admin ở đây
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }
}