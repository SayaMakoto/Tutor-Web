<?php

namespace App\Http\Requests\Frontend\CreateClass;

use Illuminate\Foundation\Http\FormRequest;

class Step4Request extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'weeks' => 'required|string',
            'schedule' => 'required|array|min:1',
            'time_start' => 'required',
            'time_end' => 'required|after:time_start',
        ];
    }

    public function messages(): array
    {
        return [
            'weeks.required' => 'Vui lòng chọn số buổi học mỗi tuần.',

            'schedule.required' => 'Vui lòng chọn ít nhất một ngày học.',
            'schedule.array' => 'Lịch học không hợp lệ.',
            'schedule.min' => 'Bạn phải chọn ít nhất một ngày học.',

            'time_start.required' => 'Vui lòng chọn giờ bắt đầu học.',
            'time_end.required' => 'Vui lòng chọn giờ kết thúc học.',
            'time_end.after' => 'Giờ kết thúc phải lớn hơn giờ bắt đầu.',
        ];
    }
}