@extends('layouts.student')
@section('title', 'Thông tin gia sư - ' . ($tutor->user->name ?? 'Gia sư'))
@section('content')
    @php
        $user = $tutor->user;

        // Giới tính Việt hoá
        $gender = match ($user->gender ?? null) {
            'male' => 'Nam',
            'female' => 'Nữ',
            default => '—',
        };

        // Lớp đã hoàn thành (dữ liệu thật từ DB)
        $completedClasses = $tutor
            ->classes()
            ->where('status', 'completed')
            ->with(['classRequest.subject', 'classRequest.grade'])
            ->latest()
            ->get()
            ->map(fn($tutorClass) => $tutorClass->classRequest);


        // Môn dạy (relation many-to-many hoặc hasMany)
        $subjects = $tutor->subjects ?? collect();

        // Reviews thật (giả sử có relation reviews)
        $reviews = $tutor->reviews()->latest()->get();

        $avgRating = round($reviews->avg('rating'), 1) ?? 0;
        $reviewCount = $reviews->count();
    @endphp

    <div class="max-w-6xl mx-auto mt-6 space-y-6">
        {{-- PROFILE --}}
        <div class="bg-white rounded-2xl shadow p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- AVATAR --}}
            <div class="flex flex-col items-center text-center">
                <div class="w-40 h-52 rounded-xl overflow-hidden shadow bg-gray-100">
                    <img src="{{ $user->avatar
                        ? asset('storage/' . $user->avatar)
                        : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}"
                        class="w-full h-full object-cover">
                </div>

                <h2 class="mt-3 text-xl font-bold text-gray-800 flex items-center gap-2">
                    <x-heroicon-o-user class="w-5 h-5 text-indigo-500" />
                    {{ $user->name }}
                </h2>

                <p class="text-yellow-500 text-sm mt-1 flex items-center gap-1">
                    <x-heroicon-o-star class="w-5 h-5 text-yellow-400" />
                    {{ $avgRating }}/5
                    <span class="text-gray-400">({{ $reviewCount }} đánh giá)</span>
                </p>
            </div>

            {{-- INFO --}}
            <div class="md:col-span-2 space-y-4">

                <h3 class="text-lg font-semibold flex items-center gap-2">
                    <x-heroicon-o-identification class="w-5 h-5 text-indigo-500" />
                    Thông tin cá nhân
                </h3>

                <div class="grid grid-cols-2 gap-3 text-sm">

                    <p class="flex items-center gap-2">
                        <x-heroicon-o-user class="w-4 h-4 text-indigo-500" /> {{ $user->name }}
                    </p>

                    <p class="flex items-center gap-2">
                        <x-heroicon-o-face-smile class="w-4 h-4 text-pink-500" /> {{ $gender }}
                    </p>

                    <p class="flex items-center gap-2">
                        <x-heroicon-o-gift class="w-4 h-4 text-purple-500" /> {{ $user->date_of_birth ?? '—' }}
                    </p>

                    <p class="flex items-center gap-2">
                        <x-heroicon-o-phone class="w-5 h-5 text-green-500" /> {{ $user->phone ?? '—' }}
                    </p>

                    <p class="col-span-2 flex items-center gap-2">
                        <x-heroicon-o-envelope class="w-5 h-5 text-red-400" /> {{ $user->email }}
                    </p>

                </div>

                {{-- EDUCATION --}}
                <div class="pt-3 border-t">
                    <h3 class="text-lg font-semibold flex items-center gap-2">
                        <x-heroicon-o-academic-cap class="w-5 h-5 text-emerald-500" />
                        Trình độ học vấn
                    </h3>

                    <p class="text-sm text-gray-600 mt-1">
                        {{ $tutor->education ?? 'Chưa cập nhật' }}
                    </p>

                    <p class="text-sm text-gray-600 mt-1">
                        Kinh nghiệm: {{ $tutor->experience ? $tutor->experience . ' năm' : 'Chưa có kinh nghiệm' }}
                    </p>
                </div>

            </div>
        </div>

        {{-- SUBJECTS --}}
        <div class="bg-white rounded-2xl shadow p-6">

            <h3 class="text-lg font-semibold mb-3 flex items-center gap-2">
                <x-heroicon-o-academic-cap class="w-5 h-5 text-blue-500" />
                Môn có thể dạy
            </h3>

            <div class="flex flex-wrap gap-2">
                @forelse($subjects as $subject)
                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm">
                        {{ $subject->name }}
                    </span>
                @empty
                    <p class="text-gray-500 text-sm">Chưa cập nhật môn dạy</p>
                @endforelse
            </div>
        </div>

        {{-- COMPLETED --}}
        <div class="bg-white rounded-2xl shadow p-6">

            <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                <x-heroicon-o-check-badge class="w-5 h-5 text-green-500" />
                Lớp đã dạy
            </h3>

            @forelse($completedClasses as $class)
                <div class="border rounded-lg p-3 mb-3 flex justify-between items-center">

                    <div>
                        <p class="font-semibold">
                            {{ $class->subject?->name ?? '—' }} - {{ $class->grade?->name ?? '—' }}
                        </p>

                        <p class="text-sm text-gray-500">
                            Học phí: {{ number_format($class->fee) }}đ
                        </p>
                    </div>

                    <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded-full">
                        Completed
                    </span>

                </div>
            @empty
                <p class="text-gray-500 text-sm">Chưa có lớp hoàn thành</p>
            @endforelse
        </div>

        {{-- REVIEWS --}}
        <div class="bg-white rounded-2xl shadow p-6">

            <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                <x-heroicon-o-star class="w-5 h-5 text-yellow-400" />
                Đánh giá từ học viên
            </h3>

            <div class="space-y-3">

                @forelse($reviews as $review)
                    <div class="border p-3 rounded-lg">
                        <p class="font-semibold">{{ $review->student->user->name ?? 'Học viên' }}</p>

                        <p class="text-yellow-500 text-sm">
                            {{ str_repeat('⭐', $review->rating) }}
                        </p>

                        <p class="text-sm text-gray-600">
                            {{ $review->comment }}
                        </p>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm">Chưa có đánh giá</p>
                @endforelse

            </div>
        </div>
        <a href="{{ url()->previous() }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
            <x-heroicon-o-arrow-left class="w-5 h-5" />
            Quay lại
        </a>
    </div>
@endsection
