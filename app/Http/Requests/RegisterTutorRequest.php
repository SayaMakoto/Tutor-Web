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
            'experience' => ['nullable', 'integer', 'min:0'],
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
            'experience.integer' => 'Kinh nghiệm (số năm) phải là một con số.',
            'experience.min' => 'Kinh nghiệm không phù hợp.',
            
            'name.required' => 'Vui lòng nhập họ tên.',
            'gender.required' => 'Vui lòng chọn giới tính.',
            'gender.in' => 'Giới tính không hợp lệ.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email này đã được sử dụng.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
            'password.min' => 'Mật khẩu phải có ít nhất :min ký tự.',
        ];
    }
}