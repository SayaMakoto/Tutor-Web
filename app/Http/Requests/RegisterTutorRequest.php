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
            'education' => ['required', 'string'],
            'experience' => ['required', 'integer', 'min:0'],
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

    public function messages(): array
    {
        return [
            'education.required' => 'Vui lòng nhập học vấn.',
            'experience.required' => 'Vui lòng nhập số năm kinh nghiệm.',
            'experience.integer' => 'Kinh nghiệm phải là một số nguyên dương.',
            'experience.min' => 'Kinh nghiệm không được âm.',
            'name.required' => 'Vui lòng nhập họ và tên.',
            'gender.required' => 'Vui lòng chọn giới tính.',
            'gender.in' => 'Giới tính không hợp lệ.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email này đã được sử dụng.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
        ];
    }
}