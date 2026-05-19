<?php

namespace App\Http\Requests\Admin\Tutor;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Sau này có thể check admin ở đây
    }

    public function rules(): array
    {
        return [
            'status' => 'required|in:pending,approved,rejected',
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'Vui lòng chọn trạng thái.',
            'status.in' => 'Trạng thái không hợp lệ.',
        ];
    }
}