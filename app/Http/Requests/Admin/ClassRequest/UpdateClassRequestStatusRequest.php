<?php

namespace App\Http\Requests\Admin\ClassRequest;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\ClassRequest;

class UpdateClassRequestStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $validStatuses = array_keys(ClassRequest::statusOptions());

        return [
            'status' => 'required|in:' . implode(',', $validStatuses),
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