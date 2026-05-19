<?php

namespace App\Http\Requests\Frontend\ClassRequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $class = $this->route('class_request');

        return $class && $class->student_id === auth()->user()->student->id;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'budget' => 'required|numeric|min:0',
            'study_type' => 'required|in:online,offline',
        ];
    }
}