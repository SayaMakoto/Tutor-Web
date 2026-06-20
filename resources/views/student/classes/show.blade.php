@extends('layouts.student')

@section('title', 'Chi tiết lớp #' . $class->id)

@section('content')
    @php
        $subjectName = $class->subject?->name ?? ($class->subject_request ?? 'Chưa xác định');
        $gradeName = $class->grade?->name ?? ($class->grade_request ?? 'Chưa xác định');
        $tutor = $class->tutor;
        $user = $tutor?->user;

        $days = ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'Chủ nhật'];
        $scheduleArr = $class->schedule ? explode(',', $class->schedule) : [];
        $scheduleArr = array_map('trim', $scheduleArr);
        $timeValue = $class->time ?? '—';
        $totalWeeks = $class->weeks ?? 1;
    @endphp

    <div class="py-6 max-w-5xl mx-auto px-4 space-y-6" x-data="{ currentWeek: 1, totalWeeks: parseInt('{{ $totalWeeks }}') || 1 }">
        <!-- Breadcrumb & Title -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-sm text-gray-500 mb-1">
                    <a href="{{ route('student.home') }}" class="hover:text-blue-600">Trang chủ</a>
                    <span>/</span>
                    <a href="{{ route('classes.index') }}" class="hover:text-blue-600">Lớp học</a>
                    <span>/</span>
                    <span class="text-gray-800 font-medium">Chi tiết lớp #{{ $class->id }}</span>
                </div>
                <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                    Chi tiết lớp học #{{ $class->id }}
                </h1>
            </div>
            <div class="flex items-center gap-3">
                <span class="px-3 py-1.5 rounded-full text-xs font-semibold {{ $class->status_color }} shadow-sm">
                    {{ $class->status_label }}
                </span>
            </div>
        </div>

        <!-- Main Detail Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Class details list (span 2) -->
            <div
                class="md:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col justify-between">
                <div class="p-6 md:p-8 space-y-6">
                    <div class="border-b border-gray-100 pb-3 flex items-center justify-between">
                        <h3 class="font-bold text-gray-800 flex items-center gap-2 text-lg">
                            <i class="fas fa-info-circle text-blue-600"></i> Thông tin yêu cầu lớp học
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-6 text-sm">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                                <i class="fas fa-book"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-medium">Môn học</p>
                                <p class="font-semibold text-gray-700">{{ $subjectName }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600">
                                <i class="fas fa-layer-group"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-medium">Khối học</p>
                                <p class="font-semibold text-gray-700">{{ $gradeName }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 sm:col-span-2">
                            <div
                                class="w-8 h-8 rounded-lg bg-rose-50 flex items-center justify-center text-rose-600 shrink-0">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-medium">Địa điểm học</p>
                                <p class="font-semibold text-gray-700">{{ $class->location ?? 'Chưa xác định' }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-medium">Học phí đề xuất</p>
                                <p class="font-bold text-emerald-600">{{ number_format($class->fee ?? 0) }} VNĐ / giờ</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-purple-50 flex items-center justify-center text-purple-600">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-medium">Thời lượng học</p>
                                <p class="font-semibold text-gray-700">{{ $totalWeeks }} tuần</p>
                            </div>
                        </div>

                        @if ($class->deleted_at)
                            <div class="flex items-center gap-3 sm:col-span-2">
                                <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center text-gray-500">
                                    <i class="fas fa-trash-alt"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 font-medium">Ngày hủy lớp</p>
                                    <p class="font-semibold text-gray-600">{{ $class->deleted_at->format('d/m/Y H:i') }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>

                    @if ($class->description)
                        <div class="pt-4 border-t border-gray-50">
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Mô tả thêm / Yêu cầu
                                chi tiết</h4>
                            <div class="p-4 bg-gray-50 rounded-xl text-sm text-gray-600 leading-relaxed">
                                {{ $class->description }}
                            </div>
                        </div>
                    @endif
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-between items-center">
                    <a href="{{ route('classes.index') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 border border-gray-200 rounded-xl text-sm font-semibold text-gray-600 bg-white hover:bg-gray-100 transition shadow-sm">
                        <i class="fas fa-arrow-left"></i> Quay lại danh sách
                    </a>
                </div>
            </div>

            <!-- Tutor profile card -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 md:p-8 flex flex-col justify-between">
                <div>
                    <h3 class="font-bold text-gray-800 text-lg border-b border-gray-100 pb-3 mb-6 flex items-center gap-2">
                        <i class="fas fa-chalkboard-teacher text-blue-600"></i> Gia sư của lớp
                    </h3>

                    @if ($tutor && $user)
                        <div class="flex flex-col items-center text-center space-y-4">
                            <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-blue-50 shadow-md">
                                <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=0D8ABC&color=fff' }}"
                                    class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 text-lg">{{ $user->name }}</h4>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $user->email }}</p>
                            </div>

                            <div class="w-full grid grid-cols-2 gap-2 text-xs py-3 border-t border-b border-gray-100 my-2">
                                <div class="p-2 bg-gray-50 rounded-xl">
                                    <span class="text-gray-400 block mb-0.5">Học vấn</span>
                                    <span class="font-bold text-gray-700 truncate block">{{ $tutor->education }}</span>
                                </div>
                                <div class="p-2 bg-gray-50 rounded-xl">
                                    <span class="text-gray-400 block mb-0.5">Kinh nghiệm</span>
                                    <span class="font-bold text-gray-700 block">{{ $tutor->experience }} năm</span>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="py-12 flex flex-col items-center justify-center text-center">
                            <div
                                class="w-16 h-16 rounded-full bg-yellow-50 flex items-center justify-center text-yellow-500 mb-4">
                                <i class="fas fa-spinner text-2xl animate-spin"></i>
                            </div>
                            <h4 class="font-bold text-gray-700 text-sm">Đang tìm gia sư...</h4>
                            <p class="text-xs text-gray-400 mt-1 max-w-50 mx-auto">Lớp học đang được gia sư ứng tuyển và chờ
                                phê duyệt từ quản trị viên.</p>
                        </div>
                    @endif
                </div>

                @if ($tutor && $user)
                    <div class="mt-6 border-t border-gray-100 pt-4">
                        <a href="{{ route('student.tutor.show', $tutor->id) }}"
                            class="w-full inline-flex items-center justify-center gap-1.5 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold transition shadow-sm">
                            <i class="fas fa-user-circle"></i> Xem hồ sơ chi tiết
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Interactive Schedule Section -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 md:p-8 space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-100 pb-4">
                <div>
                    <h3 class="font-bold text-gray-800 text-lg flex items-center gap-2">
                        <i class="fas fa-calendar-alt text-blue-600"></i> Lịch học & Thời khóa biểu
                    </h3>
                    <p class="text-xs text-gray-400 mt-0.5">Theo dõi lịch học cố định theo các tuần của khóa học.</p>
                </div>

                <!-- Week Changer Widget -->
                <div class="flex items-center gap-2">
                    <button @click="if (currentWeek > 1) currentWeek--" :disabled="currentWeek === 1"
                        class="w-9 h-9 rounded-xl border border-gray-200 flex items-center justify-center hover:bg-gray-50 transition disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas fa-chevron-left text-xs text-gray-600"></i>
                    </button>
                    <div
                        class="px-4 py-1.5 bg-blue-50 border border-blue-100 rounded-xl text-sm font-bold text-blue-700 whitespace-nowrap">
                        Tuần <span x-text="currentWeek"></span> / <span x-text="totalWeeks"></span>
                    </div>
                    <button @click="if (currentWeek < totalWeeks) currentWeek++" :disabled="currentWeek === totalWeeks"
                        class="w-9 h-9 rounded-xl border border-gray-200 flex items-center justify-center hover:bg-gray-50 transition disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas fa-chevron-right text-xs text-gray-600"></i>
                    </button>
                </div>
            </div>

            <!-- Weekly Carousel Tabs -->
            <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-none">
                <template x-for="w in totalWeeks" :key="w">
                    <button @click="currentWeek = w"
                        class="px-4 py-2 rounded-xl text-xs font-bold transition whitespace-nowrap"
                        :class="currentWeek === w ?
                            'bg-blue-600 text-white shadow-sm' :
                            'bg-gray-50 border border-gray-150 text-gray-500 hover:bg-gray-100'">
                        <span x-text="'Tuần ' + w"></span>
                    </button>
                </template>
            </div>

            <!-- Schedule Grid Display -->
            <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-7 gap-4">
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

                    <div class="rounded-2xl border p-4 text-center transition flex flex-col justify-between gap-4 min-h-27.5"
                        :class="currentWeek % 2 === 1 ?
                            '{{ $isScheduled ? 'bg-linear-to-br from-blue-500 to-indigo-600 text-white shadow-md border-transparent transform scale-[1.02]' : 'bg-white border-gray-100 text-gray-500' }}' :
                            '{{ $isScheduled ? 'bg-linear-to-br from-indigo-500 to-purple-600 text-white shadow-md border-transparent transform scale-[1.02]' : 'bg-white border-gray-100 text-gray-500' }}'">

                        <div class="text-xs font-bold tracking-wide uppercase opacity-90">
                            {{ $day }}
                        </div>

                        <div>
                            @if ($isScheduled)
                                <div class="text-xs font-bold bg-white/20 inline-block px-2.5 py-1 rounded-lg">
                                    {{ $timeValue }}
                                </div>
                                <div
                                    class="text-[10px] font-semibold mt-2 opacity-85 flex items-center justify-center gap-1">
                                    <i class="fas fa-check-circle text-white"></i> Có buổi học
                                </div>
                            @else
                                <div class="text-xs font-medium text-gray-400 py-1">—</div>
                                <div class="text-[10px] text-gray-300 font-medium mt-2">Trống lịch</div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
