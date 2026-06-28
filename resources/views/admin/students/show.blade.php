@extends('layouts.admin')
@section('title', 'Chi tiết học viên — ' . $student->user->name)

@section('content')
    @php
        $user    = $student->user;
        $classes = $student->classRequests()->with(['subject','grade'])->latest()->get();
        $reviews = $student->reviews()->with('tutor.user')->latest()->get();
        $backRoute = request('from') === 'users' ? route('admin.users.index') : route('admin.students.index');
    @endphp

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ $backRoute }}" class="hover:text-violet-600 transition">
            {{ request('from') === 'users' ? 'Người dùng' : 'Học viên' }}
        </a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-800 font-medium">{{ $user->name }}</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Cột trái: Profile --}}
        <div class="space-y-5">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 text-center">
                <img src="{{ $user->avatar
                    ? asset('storage/' . $user->avatar)
                    : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=1d4ed8&color=fff' }}"
                     class="w-24 h-24 rounded-2xl object-cover mx-auto mb-4 shadow-md" alt="avatar">

                <h2 class="text-lg font-bold text-gray-800">{{ $user->name }}</h2>
                <span class="inline-flex items-center gap-1.5 mt-2 px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">
                    <i class="fas fa-user-graduate text-xs"></i> Học viên
                </span>
            </div>

            {{-- Thông tin liên lạc --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <h3 class="font-bold text-gray-800 text-sm flex items-center gap-2 mb-4">
                    <i class="fas fa-address-card text-blue-500"></i> Thông tin cá nhân
                </h3>
                <div class="space-y-3">
                    @foreach([
                        ['fas fa-envelope',  'Email',     $user->email],
                        ['fas fa-phone',     'SĐT',       $user->phone ?? '—'],
                        ['fas fa-cake-candles','Ngày sinh',$user->date_of_birth ?? '—'],
                        ['fas fa-venus-mars','Giới tính', $user->gender ?? '—'],
                    ] as [$icon, $label, $value])
                        <div class="flex items-start gap-3">
                            <div class="w-7 h-7 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="{{ $icon }} text-blue-500 text-xs"></i>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs text-gray-400">{{ $label }}</p>
                                <p class="font-medium text-gray-700 text-sm truncate">{{ $value }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Cột phải --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Các lớp đã đăng --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-bold text-gray-800 text-sm flex items-center gap-2 mb-4">
                    <i class="fas fa-book-open text-blue-500"></i>
                    Lớp học đã đăng
                    <span class="ml-auto text-xs bg-blue-50 text-blue-600 font-semibold px-2 py-0.5 rounded-full">
                        {{ $classes->count() }}
                    </span>
                </h3>

                @forelse($classes as $class)
                    @php
                        $statusMap = [
                            'pending'   => ['label' => 'Chờ duyệt',  'bg' => 'bg-amber-100',   'text' => 'text-amber-700'],
                            'assigned'  => ['label' => 'Đã nhận',    'bg' => 'bg-blue-100',    'text' => 'text-blue-700'],
                            'completed' => ['label' => 'Hoàn thành', 'bg' => 'bg-emerald-100', 'text' => 'text-emerald-700'],
                            'cancelled' => ['label' => 'Đã huỷ',     'bg' => 'bg-red-100',     'text' => 'text-red-700'],
                        ];
                        $sc = $statusMap[$class->status] ?? ['label' => 'Không rõ', 'bg' => 'bg-gray-100', 'text' => 'text-gray-700'];
                    @endphp
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl mb-2">
                        <div>
                            <p class="font-semibold text-gray-800 text-sm">
                                {{ $class->subject?->name ?? '—' }}
                                @if($class->grade)
                                    <span class="text-gray-400 font-normal">— {{ $class->grade->name }}</span>
                                @endif
                            </p>
                            <p class="text-xs text-gray-400 mt-0.5">
                                {{ number_format($class->fee) }}đ/giờ ·
                                <a href="{{ route('admin.class-requests.show', $class->id) }}"
                                   class="text-violet-500 hover:underline">Xem chi tiết</a>
                            </p>
                        </div>
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $sc['bg'] }} {{ $sc['text'] }}">
                            {{ $sc['label'] }}
                        </span>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <i class="fas fa-folder-open text-gray-200 text-3xl mb-2"></i>
                        <p class="text-sm text-gray-400">Chưa có lớp học nào</p>
                    </div>
                @endforelse
            </div>

            {{-- Đánh giá gia sư --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-bold text-gray-800 text-sm flex items-center gap-2 mb-4">
                    <i class="fas fa-star text-amber-400"></i>
                    Đánh giá đã gửi
                    <span class="ml-auto text-xs bg-amber-50 text-amber-600 font-semibold px-2 py-0.5 rounded-full">
                        {{ $reviews->count() }}
                    </span>
                </h3>

                @forelse($reviews as $review)
                    <div class="bg-gray-50 rounded-xl p-4 mb-2">
                        <div class="flex items-center justify-between mb-1.5">
                            <p class="font-semibold text-gray-800 text-sm">
                                Gia sư: {{ $review->tutor->user->name ?? '—' }}
                            </p>
                            <div class="flex items-center gap-0.5 text-amber-400">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star text-xs {{ $i <= $review->rating ? '' : 'opacity-25' }}"></i>
                                @endfor
                                <span class="text-xs text-gray-400 ml-1">{{ $review->rating }}/5</span>
                            </div>
                        </div>
                        <p class="text-xs text-gray-600 leading-relaxed">{{ $review->comment ?? 'Không có nhận xét.' }}</p>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <i class="fas fa-star text-gray-200 text-3xl mb-2"></i>
                        <p class="text-sm text-gray-400">Chưa có đánh giá nào</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

@endsection
