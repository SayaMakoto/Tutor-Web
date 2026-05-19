@extends('layouts.admin')
@section('title', 'Chi tiết học viên')
@section('content')
    @php
        $user = $student->user;

        $classes = $student
            ->classRequests()
            ->with(['subject', 'grade'])
            ->latest()
            ->get();

        $reviews = $student->reviews()->with('tutor.user')->latest()->get();
    @endphp

    <div class="max-w-6xl mx-auto space-y-6">

        {{-- HEADER --}}
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-800">
                Chi tiết học viên
            </h2>

            @php
                $backRoute = request('from') === 'users' ? route('admin.users.index') : route('admin.students.index');
            @endphp

            <a href="{{ $backRoute }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                <x-heroicon-o-arrow-left class="w-5 h-5 text-gray-600" />
                Quay lại
            </a>
        </div>

        {{-- PROFILE --}}
        <div class="bg-white p-6 rounded-2xl shadow grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- AVATAR --}}
            <div class="flex flex-col items-center">
                <img src="{{ $user->avatar
                    ? asset('storage/' . $user->avatar)
                    : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}"
                    class="w-32 h-32 rounded-full object-cover border">

                <h3 class="mt-3 text-lg font-bold">{{ $user->name }}</h3>
            </div>

            {{-- INFO --}}
            <div class="md:col-span-2 space-y-3 text-sm">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-3 gap-x-6">

                    <p class="flex gap-2">
                        <span class="font-semibold w-32">👤 Họ tên:</span>
                        <span>{{ $user->name }}</span>
                    </p>

                    <p class="flex gap-2">
                        <span class="font-semibold w-32">📧 Email:</span>
                        <span>{{ $user->email }}</span>
                    </p>

                    <p class="flex gap-2">
                        <span class="font-semibold w-32">📞 SĐT:</span>
                        <span>{{ $user->phone ?? '—' }}</span>
                    </p>

                    <p class="flex gap-2">
                        <span class="font-semibold w-32">🎂 Ngày sinh:</span>
                        <span>{{ $user->date_of_birth ?? '—' }}</span>
                    </p>

                </div>

            </div>
        </div>

        {{-- CLASS REQUESTS --}}
        <div class="bg-white p-6 rounded-2xl shadow">

            <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                <x-heroicon-o-book-open class="w-5 h-5 text-blue-500" />
                Các lớp học đã đăng
            </h3>

            @forelse($classes as $class)
                <div class="border rounded-lg p-3 mb-3 flex justify-between">

                    <div>
                        <p class="font-semibold">
                            {{ $class->subject?->name }} - {{ $class->grade?->name }}
                        </p>

                        <p class="text-sm text-gray-500">
                            Học phí: {{ number_format($class->fee) }}đ
                        </p>
                    </div>

                    @php
                        $statusLabel = match ($class->status) {
                            'pending' => 'Chờ duyệt',
                            'assigned' => 'Đã nhận',
                            'completed' => 'Hoàn thành',
                            'cancelled' => 'Đã huỷ',
                            default => 'Không rõ',
                        };

                        $statusColor = match ($class->status) {
                            'pending' => 'bg-yellow-100 text-yellow-700',
                            'assigned' => 'bg-blue-100 text-blue-700',
                            'completed' => 'bg-green-100 text-green-700',
                            'cancelled' => 'bg-red-100 text-red-700',
                            default => 'bg-gray-100 text-gray-700',
                        };
                    @endphp

                    <span class="px-2 py-1 text-xs rounded-full {{ $statusColor }}">
                        {{ $statusLabel }}
                    </span>
                </div>
            @empty
                <p class="text-gray-500 text-sm">Chưa có lớp học nào</p>
            @endforelse

        </div>

        {{-- REVIEWS --}}
        <div class="bg-white p-6 rounded-2xl shadow">

            <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                <x-heroicon-o-chat-bubble-left-right class="w-5 h-5 text-purple-500" />
                Bình luận / đánh giá gia sư
            </h3>

            @forelse($reviews as $review)
                <div class="border rounded-lg p-3 mb-3">

                    <p class="font-semibold">
                        Gia sư: {{ $review->tutor->user->name ?? '—' }}
                    </p>

                    <p class="text-yellow-500 text-sm">
                        ⭐ {{ $review->rating }}/5
                    </p>

                    <p class="text-sm text-gray-600 mt-1">
                        {{ $review->comment }}
                    </p>

                </div>
            @empty
                <p class="text-gray-500 text-sm">Chưa có đánh giá nào</p>
            @endforelse

        </div>

    </div>
@endsection
