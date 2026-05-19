<?php

namespace App\Http\Requests\Admin\ClassRequest;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubjectFromRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }
}