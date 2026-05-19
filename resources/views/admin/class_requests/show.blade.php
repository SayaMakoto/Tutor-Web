@extends('layouts.admin')
@section('title', 'Chi tiết yêu cầu đăng lớp')
@section('content')
    @php
        $days = ['T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'CN'];
        $scheduleArr = $classRequest->schedule ? array_map('trim', explode(',', $classRequest->schedule)) : [];
    @endphp

    <div class="bg-white p-8 rounded-xl shadow">

        <h2 class="text-2xl font-bold mb-6">
            Chi tiết yêu cầu lớp #{{ $classRequest->id }}
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

            {{-- ================= THÔNG TIN LỚP ================= --}}
            <div class="space-y-4">

                <h3 class="text-xl font-semibold">Thông tin lớp</h3>

                {{-- ================= MÔN HỌC ================= --}}
                <div>
                    <strong>Môn học:</strong>

                    @if ($classRequest->subject_id)
                        <span class="text-green-700 font-semibold">
                            {{ $classRequest->subject?->name }}
                        </span>
                    @elseif ($classRequest->subject_request)
                        <span class="text-orange-600 font-semibold">
                            {{ $classRequest->subject_request }}
                        </span>

                        <div class="mt-3 p-4 bg-orange-50 border border-orange-200 rounded-lg">
                            <p class="text-sm text-orange-700 mb-2">
                                Môn học này chưa có trong hệ thống.
                            </p>

                            <form action="{{ route('admin.class-requests.create-subject', $classRequest->id) }}"
                                method="POST" class="space-y-2">
                                @csrf

                                <div>
                                    <label class="text-sm font-medium">
                                        Tên môn học sẽ lưu vào hệ thống:
                                    </label>
                                    <input type="text" name="name"
                                        value="{{ old('name', $classRequest->subject_request) }}"
                                        class="w-full mt-1 border rounded-lg p-2" required>
                                </div>

                                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">
                                    ➕ Thêm vào danh sách môn học
                                </button>
                            </form>
                        </div>
                    @else
                        <span class="text-gray-500">Không xác định</span>
                    @endif
                </div>

                <div>
                    <strong>Ngành học:</strong>

                    @if ($classRequest->grade_id)
                        <span class="text-green-700 font-semibold">
                            {{ $classRequest->grade?->name }}
                        </span>
                    @elseif ($classRequest->grade_request)
                        <span class="text-orange-600 font-semibold">
                            {{ $classRequest->grade_request }}
                        </span>

                        <div class="mt-3 p-4 bg-orange-50 border border-orange-200 rounded-lg">
                            <p class="text-sm text-orange-700 mb-2">
                                Ngành học này chưa có trong hệ thống.
                            </p>

                            <form action="{{ route('admin.class-requests.create-grade', $classRequest->id) }}"
                                method="POST" class="space-y-2">
                                @csrf

                                <div>
                                    <label class="text-sm font-medium">
                                        Tên ngành học sẽ lưu vào hệ thống:
                                    </label>
                                    <input type="text" name="name"
                                        value="{{ old('name', $classRequest->grade_request) }}"
                                        class="w-full mt-1 border rounded-lg p-2" required>
                                </div>

                                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">
                                    ➕ Thêm vào danh sách ngành học
                                </button>
                            </form>
                        </div>
                    @else
                        <span class="text-gray-500">Không xác định</span>
                    @endif
                </div>

                <p><strong>Học phí:</strong> {{ number_format($classRequest->fee) }} VNĐ / giờ</p>
                <p><strong>Hình thức học:</strong> {{ ucfirst($classRequest->study_type) }}</p>
                <p><strong>Địa điểm:</strong> {{ $classRequest->location ?? '-' }}</p>
                <p><strong>Thời lượng:</strong> {{ $classRequest->weeks }}</p>

                <p><strong>Trạng thái:</strong>
                    <span class="px-2 py-1 rounded-full text-xs {{ $classRequest->status_color }}">
                        {{ $classRequest->status_label }}
                    </span>
                </p>

            </div>

            {{-- ================= YÊU CẦU GIA SƯ ================= --}}
            <div class="space-y-4">

                <h3 class="text-xl font-semibold">Yêu cầu gia sư</h3>

                <p><strong>Học vấn:</strong> {{ $classRequest->degree ?? '-' }}</p>
                <p><strong>Kinh nghiệm:</strong> {{ $classRequest->experience ?? '-' }}</p>
                <p><strong>Giới tính:</strong> {{ $classRequest->gender_label }}</p>
                <p><strong>Độ tuổi:</strong> {{ $classRequest->age_range ?? 'Không yêu cầu' }}</p>

                <div>
                    <strong>Mô tả thêm:</strong>
                    <div class="mt-2 p-3 bg-gray-50 border rounded-lg text-sm">
                        {{ $classRequest->description ?? 'Không có mô tả thêm.' }}
                    </div>
                </div>

            </div>

        </div>
    </div>

    {{-- ================= THỜI KHÓA BIỂU ================= --}}
    <div class="bg-white p-8 rounded-xl shadow mt-6">

        <h3 class="text-xl font-semibold mb-4">Thời khóa biểu</h3>

        <div class="grid grid-cols-7 gap-2 text-center">
            @foreach ($days as $day)
                <div class="border rounded-lg p-3">
                    <div class="font-semibold">{{ $day }}</div>
                    <div
                        class="text-sm mt-1 
                        {{ in_array($day, $scheduleArr) ? 'text-blue-600' : 'text-gray-400' }}">
                        {{ in_array($day, $scheduleArr) ? $classRequest->time : '—' }}
                    </div>
                </div>
            @endforeach
        </div>

    </div>
    <div class="flex justify-center mt-6">
        <a href="{{ route('admin.class-requests.index') }}"
            class="px-5 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 font-medium">
            ← Quay lại danh sách yêu cầu
        </a>
    </div>
@endsection
