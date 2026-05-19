<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterTutorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'bio' => ['nullable', 'string'],
            'education' => ['nullable', 'string'],
            'experience' => ['nullable', 'string'],
        ];

        if (!auth()->check()) {
            $rules = array_merge($rules, [
                'name' => ['required'],
                'gender' => ['required', 'in:male,female'],
                'email' => ['required', 'email', 'unique:users,email'],
                'password' => ['required', 'confirmed', 'min:6'],
            ]);
        }

        return $rules;
    }
}