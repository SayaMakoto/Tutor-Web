@extends('layouts.admin')
@section('title', 'Chi tiết gia sư')
@section('content')
    <div class="bg-white p-8 rounded-2xl shadow-md max-w-5xl mx-auto">

        {{-- Nút quay lại --}}
        @php
            $backRoute = request('from') === 'users' ? route('admin.users.index') : route('admin.tutors.index');
        @endphp

        <a href="{{ $backRoute }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
            <x-heroicon-o-arrow-left class="w-5 h-5 text-gray-600" />
            Quay lại
        </a>

        {{-- ================= AVATAR + RATING ================= --}}
        <div class="text-center">

            {{-- Avatar 3:4 --}}
            @if ($tutor->user->avatar ?? false)
                <div class="w-64 mx-auto aspect-3/4">
                    <img src="{{ asset('storage/' . $tutor->user->avatar) }}"
                        class="w-full h-full object-cover rounded-2xl shadow-lg">
                </div>
            @else
                <div
                    class="w-64 mx-auto aspect-3/4 
                        flex items-center justify-center 
                        bg-gray-100 rounded-2xl text-gray-500">
                    Chưa có avatar
                </div>
            @endif

            {{-- Đánh giá --}}
            @php
                $avgRating = round($tutor->reviews->avg('rating'), 1);
                $totalReviews = $tutor->reviews->count();
            @endphp

            <div class="mt-4">
                @if ($totalReviews > 0)
                    <div class="text-yellow-500 text-lg">
                        ★ {{ $avgRating }} / 5
                    </div>
                    <div class="text-sm text-gray-500">
                        {{ $totalReviews }} đánh giá
                    </div>
                @else
                    <div class="text-gray-500 text-sm">
                        Chưa có đánh giá
                    </div>
                @endif
            </div>

            {{-- Trạng thái --}}
            <div class="mt-3">
                <span class="px-4 py-1 rounded-full text-sm {{ $tutor->status_color }}">
                    {{ $tutor->status_label }}
                </span>
            </div>

        </div>

        {{-- ================= THÔNG TIN CÁ NHÂN ================= --}}
        <div class="mt-10 space-y-6">

            <div>
                <h3 class="text-xl font-semibold mb-3 border-b pb-2">
                    Thông tin cá nhân
                </h3>

                <p><strong>Tên:</strong> {{ $tutor->user->name }}</p>
                <p><strong>Email:</strong> {{ $tutor->user->email }}</p>
                <p class="mt-2">
                    <strong>Giới thiệu:</strong><br>
                    {{ $tutor->bio ?? 'Chưa cập nhật.' }}
                </p>
            </div>

            {{-- ================= TRÌNH ĐỘ ================= --}}
            <div>
                <h3 class="text-xl font-semibold mb-3 border-b pb-2">
                    Trình độ
                </h3>

                <p><strong>Học vấn:</strong> {{ $tutor->education ?? 'Chưa cập nhật.' }}</p>
                <p><strong>Kinh nghiệm:</strong> {{ $tutor->experience ?? 'Chưa cập nhật.' }} năm</p>

                <div class="mt-3">
                    <strong>Môn có thể dạy:</strong>
                    @if ($tutor->subjects->count())
                        <div class="flex flex-wrap gap-2 mt-2">
                            @foreach ($tutor->subjects as $subject)
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm">
                                    {{ $subject->name }}
                                </span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 mt-1">Chưa đăng ký môn học.</p>
                    @endif
                </div>
            </div>

            {{-- ================= HỒ SƠ LIÊN QUAN ================= --}}
            <div>
                <h3 class="text-xl font-semibold mb-3 border-b pb-2">
                    Hồ sơ liên quan
                </h3>

                @if ($tutor->documents->count())
                    <ul class="space-y-2">
                        @foreach ($tutor->documents as $doc)
                            <li>
                                <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank"
                                    class="text-blue-500 hover:underline">
                                    Xem {{ $doc->type_label }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500">Chưa có hồ sơ nào được tải lên.</p>
                @endif
            </div>

            {{-- ================= ĐÁNH GIÁ ================= --}}
            <div>
                <h3 class="text-xl font-semibold mb-3 border-b pb-2">
                    Đánh giá từ học viên
                </h3>

                @if ($tutor->reviews->count())
                    <div class="space-y-4">
                        @foreach ($tutor->reviews as $review)
                            <div class="p-4 bg-gray-50 rounded-xl border">
                                <div class="flex justify-between items-center mb-2">
                                    <strong>{{ $review->student->user->name }}</strong>
                                    <span class="text-yellow-500">
                                        ★ {{ $review->rating }}/5
                                    </span>
                                </div>
                                <p class="text-gray-700 text-sm">
                                    {{ $review->comment ?? 'Không có nhận xét.' }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">Chưa có đánh giá nào.</p>
                @endif
            </div>

        </div>
    </div>
@endsection
