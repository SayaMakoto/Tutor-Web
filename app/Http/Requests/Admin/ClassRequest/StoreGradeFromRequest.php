<?php

namespace App\Http\Requests\Admin\ClassRequest;

use Illuminate\Foundation\Http\FormRequest;

class StoreGradeFromRequest extends FormRequest
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