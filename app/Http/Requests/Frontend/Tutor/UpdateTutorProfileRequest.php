<?php

namespace App\Http\Requests\Frontend\Tutor;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTutorProfileRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() && auth()->user()->role === 'tutor';
    }

    public function rules()
    {
        return [
            'bio' => 'required|string|max:2000',
            'education' => 'required|string|max:1000',
            'experience' => 'required|string|max:2000',

            'subjects' => 'required|array|min:1',
            'subjects.*' => 'exists:subjects,id',

            'documents' => 'nullable|array',
            'documents.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'bio.required' => 'Vui lòng nhập phần giới thiệu bản thân.',
            'bio.max' => 'Phần giới thiệu không được vượt quá 2000 ký tự.',

            'education.required' => 'Vui lòng nhập thông tin học vấn.',
            'education.max' => 'Thông tin học vấn không được vượt quá 1000 ký tự.',

            'experience.required' => 'Vui lòng nhập kinh nghiệm giảng dạy.',
            'experience.max' => 'Kinh nghiệm không được vượt quá 2000 ký tự.',

            'subjects.required' => 'Bạn phải chọn ít nhất một môn dạy.',
            'subjects.array' => 'Danh sách môn học không hợp lệ.',
            'subjects.min' => 'Bạn phải chọn ít nhất một môn dạy.',
            'subjects.*.exists' => 'Có môn học không tồn tại trong hệ thống.',

            'documents.array' => 'Danh sách tài liệu không hợp lệ.',
            'documents.*.file' => 'Vui lòng chọn đúng tệp hợp lệ.',
            'documents.*.mimes' => 'Tài liệu phải có định dạng: jpg, jpeg, png hoặc pdf.',
            'documents.*.max' => 'Mỗi tài liệu không được vượt quá 2MB.',
        ];
    }

    public function attributes()
    {
        return [
            'bio' => 'giới thiệu',
            'education' => 'học vấn',
            'experience' => 'kinh nghiệm',
            'subjects' => 'môn học',
            'documents' => 'tài liệu',
        ];
    }
}