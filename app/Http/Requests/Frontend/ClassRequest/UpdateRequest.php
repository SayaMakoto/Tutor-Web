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
            'grade_id' => 'required|exists:grades,id',
            'subject_id' => 'required|exists:subjects,id',
            'degree' => 'nullable|string',
            'experience' => 'nullable|string',
            'gender' => 'nullable|string',
            'age_range' => 'nullable|string',
            'fee' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'study_type' => 'required|in:online,offline',
            'location' => 'nullable|string',
            'weeks' => 'required|string',
        ];
    }
}