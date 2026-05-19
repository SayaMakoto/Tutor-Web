<?php

namespace App\Http\Requests\Frontend\CreateClass;

use Illuminate\Foundation\Http\FormRequest;

class Step2Request extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'degree' => 'required|string',
            'experience' => 'required|string',
            'gender' => 'required|in:male,female,no_need',
            'age_range' => 'required|string',
            'fee' => 'required|numeric|min:0|max:2000000',
            'description' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'degree.required' => 'Vui lòng chọn trình độ gia sư.',
            'experience.required' => 'Vui lòng chọn kinh nghiệm.',
            'gender.required' => 'Vui lòng chọn giới tính gia sư.',
            'gender.in' => 'Giới tính không hợp lệ.',
            'age_range.required' => 'Vui lòng chọn độ tuổi gia sư.',
            'fee.required' => 'Vui lòng nhập học phí mong muốn.',
            'fee.numeric' => 'Học phí phải là số.',
            'fee.min' => 'Học phí không được nhỏ hơn 0đ.',
            'fee.max' => 'Học phí không được vượt quá 2.000.000đ.',
        ];
    }
}