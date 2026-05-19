<?php

namespace App\Http\Requests\Frontend\CreateClass;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Subject;

class Step1Request extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'grade_id' => ['required'],
            'grade_request' => ['nullable', 'string'],

            'subject_id' => ['required'],
            'subject_request' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'grade_id.required' => 'Vui lòng chọn ngành học.',
            'subject_id.required' => 'Vui lòng chọn môn học.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            $gradeId = $this->grade_id;
            $subjectId = $this->subject_id;

            // Nếu chọn "other" thì bỏ qua kiểm tra quan hệ
            if (!$gradeId || !$subjectId || $gradeId === 'other' || $subjectId === 'other') {
                return;
            }

            $subject = Subject::where('id', $subjectId)
                ->whereHas('grades', function ($q) use ($gradeId) {
                    $q->where('grades.id', $gradeId);
                })
                ->exists();

            if (!$subject) {
                $validator->errors()->add(
                    'subject_id',
                    'Môn học không thuộc ngành đã chọn.'
                );
            }
        });
    }
}