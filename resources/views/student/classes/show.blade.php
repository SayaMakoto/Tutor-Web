@extends('layouts.student')
@section('title', 'Chi tiết lớp #' . $class->id)
@section('content')
    @php
        // Lấy tên môn học
        $subjectName = $class->subject?->name ?? ($class->subject_request ?? 'Chưa xác định');

        // Lấy tên ngành học
        $gradeName = $class->grade?->name ?? ($class->grade_request ?? 'Chưa xác định');

        // Lấy thông tin gia sư
        $tutor = $class->tutor;
        $user = $tutor?->user;

        // Tuần hiện tại mặc định 1
        $currentWeek = 1;
    @endphp

    @php
        $days = ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'Chủ nhật'];

        // Tách schedule, trim
        $scheduleArr = $class->schedule ? explode(',', $class->schedule) : [];
        $scheduleArr = array_map('trim', $scheduleArr);

        // Giờ cố định
        $timeValue = $class->time ?? '—';
    @endphp

    <div class="bg-white p-8 rounded-xl shadow">

        {{-- Tiêu đề lớp --}}
        <h2 class="text-2xl font-bold mb-6">
            Chi tiết lớp {{ $class->id }}
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Thông tin lớp --}}
            <div class="space-y-3">

                <p>
                    <strong>📘 Môn học:</strong> {{ $subjectName }}
                </p>

                <p>
                    <strong>🏫 Ngành học:</strong> {{ $gradeName }}
                </p>

                <p>
                    <strong>📍 Địa chỉ:</strong> {{ $class->location ?? 'Chưa xác định' }}
                </p>

                <p>
                    <strong>ℹ️ Trạng thái:</strong> {{ $class->status_label }}
                </p>

                <p>
                    <strong>🗑 Ngày hủy lớp:</strong> {{ $class->deleted_at?->format('d/m/Y H:i') ?? '-' }}
                </p>

            </div>

            {{-- Thông tin gia sư --}}
            <div class="space-y-3">
                <h3 class="text-xl font-semibold mb-2">Thông tin gia sư</h3>

                @if ($tutor && $user)
                    <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl border">

                        {{-- Avatar --}}
                        <div class="w-14 h-14 rounded-full overflow-hidden bg-gray-200 shrink-0">
                            <img src="{{ $user->avatar
                                ? asset('storage/' . $user->avatar)
                                : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}"
                                alt="avatar" class="w-full h-full object-cover">
                        </div>

                        {{-- Info --}}
                        <div class="flex-1">
                            <p class="font-semibold text-gray-800">
                                {{ $user->name }}
                            </p>

                            <p class="text-sm text-gray-600">
                                {{ $user->email }}
                            </p>
                        </div>

                        {{-- CTA --}}
                        <a href="{{ route('student.tutor.show', $tutor->id) }}"
                            class="px-3 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 transition">
                            Xem chi tiết
                        </a>

                    </div>
                @else
                    <p class="text-gray-500">Chưa có gia sư nhận lớp</p>
                @endif
            </div>

        </div>

    </div>

    {{-- Thời khóa biểu --}}
    <div class="bg-white p-8 rounded-xl shadow mt-6">

        <h3 class="text-xl font-bold mb-4">Thời khóa biểu</h3>

        {{-- Nút tuần trước/tuần sau --}}
        <div class="flex items-center justify-center mb-4 gap-4">
            <button class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">Tuần trước</button>
            <span>Tuần {{ $currentWeek }}/{{ $class->weeks ?? 1 }}</span>
            <button class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">Tuần sau</button>
        </div>

        {{-- Các ô thứ 2 → Chủ nhật --}}
        <div class="grid grid-cols-7 gap-2 text-center">
            @foreach ($days as $day)
                @php
                    $dayCode = match ($day) {
                        'Thứ 2' => 'T2',
                        'Thứ 3' => 'T3',
                        'Thứ 4' => 'T4',
                        'Thứ 5' => 'T5',
                        'Thứ 6' => 'T6',
                        'Thứ 7' => 'T7',
                        'Chủ nhật' => 'CN',
                    };

                    $isScheduled = in_array($dayCode, $scheduleArr);
                @endphp

                <div class="border rounded-lg p-2 min-h-15">
                    <div class="font-semibold">{{ $day }}</div>
                    <div class="text-sm mt-1 {{ $isScheduled ? 'text-blue-600' : 'text-gray-400' }}">
                        {{ $isScheduled ? $timeValue : '—' }}
                    </div>
                </div>
            @endforeach
        </div>

    </div>
    <div class="flex justify-center mt-4">
        <a href="{{ route('classes.index') }}" class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">
            Quay lại danh sách lớp
        </a>
    </div>
@endsection
