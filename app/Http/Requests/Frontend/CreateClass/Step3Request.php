<?php

namespace App\Http\Requests\Frontend\CreateClass;

use Illuminate\Foundation\Http\FormRequest;

class Step3Request extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'study_type' => 'required|in:online,offline',

            'province' => 'required_if:study_type,offline|nullable|string',
            'ward' => 'required_if:study_type,offline|nullable|string',

            'detail_address' => 'nullable|string|max:255',

            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',

            'full_address' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'study_type.required' => 'Vui lòng chọn hình thức học (online hoặc offline).',
            'study_type.in' => 'Hình thức học không hợp lệ.',

            'province.required_if' => 'Vui lòng chọn tỉnh/thành phố khi học offline.',
            'ward.required_if' => 'Vui lòng chọn phường/xã khi học offline.',

            'detail_address.max' => 'Địa chỉ chi tiết không được vượt quá 255 ký tự.',

            'latitude.numeric' => 'Tọa độ không hợp lệ.',
            'longitude.numeric' => 'Tọa độ không hợp lệ.',

            'full_address.max' => 'Địa chỉ đầy đủ không được vượt quá 500 ký tự.',
        ];
    }
}