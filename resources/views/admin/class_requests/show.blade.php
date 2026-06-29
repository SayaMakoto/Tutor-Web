@extends('layouts.admin')
@section('title', 'Chi tiết yêu cầu lớp #' . $classRequest->id)

@section('content')
    @php
        $days        = ['T2','T3','T4','T5','T6','T7','CN'];
        $scheduleArr = $classRequest->schedules->pluck('day_of_week')->toArray();
        
        $scheduleMap = [];
        foreach ($classRequest->schedules as $sched) {
            $scheduleMap[$sched->day_of_week] = \Carbon\Carbon::parse($sched->start_time)->format('H:i') . ' - ' . \Carbon\Carbon::parse($sched->end_time)->format('H:i');
        }
    @endphp

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('admin.class-requests.index') }}" class="hover:text-violet-600 transition">Đơn đăng lớp</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-800 font-medium">Lớp #{{ $classRequest->id }}</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Cột trái: Thông tin lớp --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Card chính --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="bg-gradient-to-br from-violet-600 to-indigo-700 px-6 py-5 relative overflow-hidden">
                    <div class="absolute -top-6 -right-6 w-24 h-24 bg-white/10 rounded-full"></div>
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-white/70 text-xs font-medium mb-1">Yêu cầu mở lớp</p>
                            <h2 class="text-white font-bold text-lg">Lớp #{{ $classRequest->id }}</h2>
                            <p class="text-violet-200 text-sm mt-0.5">{{ $classRequest->student_name }}</p>
                        </div>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-white/20 text-white">
                            {{ $classRequest->status_label }}
                        </span>
                    </div>
                </div>

                <div class="p-6 grid sm:grid-cols-2 gap-5">
                    {{-- Môn học --}}
                    <div>
                        <p class="text-xs text-gray-400 mb-1">Môn học</p>
                        @if($classRequest->subject_id)
                            @if($classRequest->subject?->is_approved)
                                <p class="font-semibold text-emerald-700 flex items-center gap-1.5">
                                    <i class="fas fa-check-circle text-emerald-500 text-xs"></i>
                                    {{ $classRequest->subject?->name }}
                                </p>
                            @else
                                <p class="font-semibold text-amber-700 flex items-center gap-1.5">
                                    <i class="fas fa-triangle-exclamation text-amber-500 text-xs"></i>
                                    {{ $classRequest->subject?->name }}
                                    <span class="text-xs text-amber-500 font-normal">(chưa duyệt)</span>
                                </p>
                            @endif
                        @else
                            <p class="text-gray-400 text-sm">Không xác định</p>
                        @endif
                    </div>

                    {{-- Ngành học --}}
                    <div>
                        <p class="text-xs text-gray-400 mb-1">Ngành học</p>
                        @if($classRequest->grade_id)
                            @if($classRequest->grade?->is_approved)
                                <p class="font-semibold text-emerald-700 flex items-center gap-1.5">
                                    <i class="fas fa-check-circle text-emerald-500 text-xs"></i>
                                    {{ $classRequest->grade?->name }}
                                </p>
                            @else
                                <p class="font-semibold text-amber-700 flex items-center gap-1.5">
                                    <i class="fas fa-triangle-exclamation text-amber-500 text-xs"></i>
                                    {{ $classRequest->grade?->name }}
                                    <span class="text-xs text-amber-500 font-normal">(chưa duyệt)</span>
                                </p>
                            @endif
                        @else
                            <p class="text-gray-400 text-sm">Không xác định</p>
                        @endif
                    </div>

                    <div>
                        <p class="text-xs text-gray-400 mb-1">Học phí</p>
                        <p class="font-semibold text-gray-800">{{ number_format($classRequest->fee) }} VNĐ / giờ</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-1">Hình thức</p>
                        <p class="font-semibold text-gray-800">{{ ucfirst($classRequest->study_type) }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-1">Địa điểm</p>
                        <p class="font-semibold text-gray-800">{{ $classRequest->location ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-1">Thời lượng</p>
                        <p class="font-semibold text-gray-800">{{ $classRequest->weeks }} tuần</p>
                    </div>
                </div>
            </div>

            {{-- Thêm môn/ngành chưa duyệt --}}
            @if($classRequest->subject && !$classRequest->subject->is_approved)
                <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5">
                    <div class="flex items-center gap-2 mb-3">
                        <i class="fas fa-triangle-exclamation text-amber-500"></i>
                        <p class="font-semibold text-amber-800 text-sm">Hiện chưa có môn học trong hệ thống</p>
                    </div>
                    <form action="{{ route('admin.class-requests.create-subject', $classRequest->id) }}" method="POST" class="flex gap-2">
                        @csrf
                        <input type="text" name="name" value="{{ old('name', $classRequest->subject->name) }}" required
                               class="flex-1 border border-amber-300 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-amber-400 focus:outline-none">
                        <button class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-sm font-semibold transition">
                            <i class="fas fa-plus mr-1"></i> Thêm ngay
                        </button>
                    </form>
                </div>
            @endif

            @if($classRequest->grade && !$classRequest->grade->is_approved)
                <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5">
                    <div class="flex items-center gap-2 mb-3">
                        <i class="fas fa-triangle-exclamation text-amber-500"></i>
                        <p class="font-semibold text-amber-800 text-sm">Hiện chưa có ngành học trong hệ thống</p>
                    </div>
                    <form action="{{ route('admin.class-requests.create-grade', $classRequest->id) }}" method="POST" class="flex gap-2">
                        @csrf
                        <input type="text" name="name" value="{{ old('name', $classRequest->grade->name) }}" required
                               class="flex-1 border border-amber-300 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-amber-400 focus:outline-none">
                        <button class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-sm font-semibold transition">
                            <i class="fas fa-plus mr-1"></i> Thêm ngay
                        </button>
                    </form>
                </div>
            @endif

            {{-- Thời khóa biểu --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2 text-sm">
                    <i class="fas fa-calendar-week text-violet-500"></i> Thời khóa biểu
                </h3>
                <div class="grid grid-cols-7 gap-2 text-center">
                    @foreach($days as $day)
                        @php $active = in_array($day, $scheduleArr); @endphp
                        <div class="rounded-xl p-2 text-xs {{ $active ? 'bg-violet-50 border border-violet-200' : 'bg-gray-50 border border-gray-100' }}">
                            <div class="font-bold {{ $active ? 'text-violet-700' : 'text-gray-400' }} mb-1">{{ $day }}</div>
                            <div class="text-xs {{ $active ? 'text-violet-600' : 'text-gray-300' }}">
                                {{ $active ? ($scheduleMap[$day] ?? '—') : '—' }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Cột phải: Yêu cầu gia sư --}}
        <div class="space-y-5">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2 text-sm">
                    <i class="fas fa-user-check text-violet-500"></i> Yêu cầu gia sư
                </h3>
                <div class="space-y-3 text-sm">
                    @foreach([
                        ['fas fa-graduation-cap','Học vấn',     $classRequest->degree     ?? '—'],
                        ['fas fa-briefcase',     'Kinh nghiệm', $classRequest->experience ? $classRequest->experience . ' năm' : 'Chưa có kinh nghiệm'],
                        ['fas fa-venus-mars',    'Giới tính',   $classRequest->gender_label],
                        ['fas fa-child',         'Độ tuổi',     $classRequest->age_range  ?? 'Không yêu cầu'],
                    ] as [$icon, $label, $value])
                        <div class="flex items-start gap-3">
                            <div class="w-7 h-7 bg-violet-50 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="{{ $icon }} text-violet-500 text-xs"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400">{{ $label }}</p>
                                <p class="font-medium text-gray-700">{{ $value }}</p>
                            </div>
                        </div>
                    @endforeach

                    @if($classRequest->description)
                        <div class="pt-3 border-t border-gray-100">
                            <p class="text-xs text-gray-400 mb-1.5">Mô tả thêm</p>
                            <p class="text-gray-600 text-xs leading-relaxed bg-gray-50 rounded-xl p-3">{{ $classRequest->description }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <a href="{{ route('admin.class-requests.index') }}"
               class="flex items-center justify-center gap-2 w-full px-4 py-2.5
                      bg-white border border-gray-200 text-gray-600 rounded-xl text-sm
                      hover:bg-gray-50 transition">
                <i class="fas fa-arrow-left text-xs"></i> Quay lại danh sách
            </a>
        </div>
    </div>
@endsection
