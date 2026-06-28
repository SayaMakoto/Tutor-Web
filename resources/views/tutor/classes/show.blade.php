@extends('layouts.tutor')

@section('title', 'Chi tiết lớp #' . $class->id)

@section('content')
    @php
        $subjectName = $class->subject?->name ?? 'Chưa xác định';
        $gradeName = $class->grade?->name ?? 'Chưa xác định';
        $student = $class->student;
        $studentUser = $student?->user;

        $days = ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'Chủ nhật'];
        $scheduleArr = $class->schedules->pluck('day_of_week')->toArray();
        
        $firstSchedule = $class->schedules->first();
        if ($firstSchedule) {
            $timeValue = \Carbon\Carbon::parse($firstSchedule->start_time)->format('H:i') . ' - ' . \Carbon\Carbon::parse($firstSchedule->end_time)->format('H:i');
        } else {
            $timeValue = '—';
        }
        
        $weeksStr = $class->weeks ?? '1 tuần';
        $totalWeeks = 1;
        if (preg_match('/(\d+)\s*(tuần|tháng)/i', $weeksStr, $matches)) {
            $val = intval($matches[1]);
            $unit = mb_strtolower(trim($matches[2]));
            if ($unit === 'tháng') {
                $totalWeeks = intval(round($val * 4.33));
            } else {
                $totalWeeks = $val;
            }
        } else if (is_numeric($weeksStr)) {
            $totalWeeks = intval($weeksStr);
        }
    @endphp

    <div class="py-6 max-w-5xl mx-auto px-4 space-y-6" x-data="{ currentWeek: 1, totalWeeks: parseInt('{{ $totalWeeks }}') || 1 }">
        <!-- Breadcrumb & Title -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-sm text-gray-500 mb-1">
                    <a href="{{ route('tutor.home') }}" class="hover:text-green-600">Dashboard</a>
                    <span>/</span>
                    <a href="{{ route('tutor.classes.index') }}" class="hover:text-green-600">Lớp học</a>
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
                    <div class="border-b border-gray-100 pb-3">
                        <h3 class="font-bold text-gray-800 flex items-center gap-2 text-lg">
                            <i class="fas fa-info-circle text-green-600"></i> Yêu cầu lớp học chi tiết
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-6 text-sm">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center text-green-600">
                                <i class="fas fa-book"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-medium">Môn học</p>
                                <p class="font-semibold text-gray-700">{{ $subjectName }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600">
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
                                <p class="text-xs text-gray-400 font-medium">Khu vực / Địa chỉ học</p>
                                <p class="font-semibold text-gray-700">{{ $class->location ?? 'Chưa xác định' }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-medium">Học phí gia sư đề xuất</p>
                                <p class="font-bold text-blue-600">{{ number_format($class->fee ?? 0) }} VNĐ / giờ</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-purple-50 flex items-center justify-center text-purple-600">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-medium">Thời lượng lớp học</p>
                                <p class="font-semibold text-gray-700">{{ $class->weeks ?? '—' }}</p>
                            </div>
                        </div>
                    </div>

                    @if ($class->description)
                        <div class="pt-4 border-t border-gray-50">
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Yêu cầu chi tiết từ
                                học viên</h4>
                            <div class="p-4 bg-gray-50 rounded-xl text-sm text-gray-600 leading-relaxed">
                                {{ $class->description }}
                            </div>
                        </div>
                    @endif
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                    <a href="{{ url()->previous() ?? route('tutor.classes.index') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 border border-gray-200 rounded-xl text-sm font-semibold text-gray-600 bg-white hover:bg-gray-100 transition shadow-sm">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </div>

            <!-- Student profile card & Actions -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 md:p-8 flex flex-col justify-between">
                <div class="space-y-6">
                    <!-- Student Profile Section -->
                    <div>
                        <h3
                            class="font-bold text-gray-800 text-lg border-b border-gray-100 pb-3 mb-4 flex items-center gap-2">
                            <i class="fas fa-user-graduate text-green-600"></i> Học viên đăng ký
                        </h3>

                        @if ($studentUser)
                            <div class="flex items-center gap-3 p-3 bg-gray-50/50 rounded-xl border border-gray-100">
                                <div class="w-12 h-12 rounded-full overflow-hidden shrink-0 border border-gray-250">
                                    <img src="{{ $studentUser->avatar ? asset('storage/' . $studentUser->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($studentUser->name) . '&background=10B981&color=fff' }}"
                                        class="w-full h-full object-cover">
                                </div>
                                <div class="overflow-hidden">
                                    <h4 class="font-bold text-gray-800 text-sm truncate">{{ $studentUser->name }}</h4>
                                    <p class="text-[11px] text-gray-400 truncate">{{ $studentUser->email }}</p>
                                </div>
                            </div>
                        @else
                            <p class="text-xs text-gray-400">Không tìm thấy thông tin học viên.</p>
                        @endif
                    </div>

                    <!-- Action Section -->
                    <div>
                        <h3 class="font-bold text-gray-800 text-sm border-b border-gray-100 pb-2 mb-3">
                            Hành động gia sư
                        </h3>

                        @if ($class->status !== 'assigned')
                            <div class="space-y-3">
                                <p class="text-xs text-gray-500 leading-relaxed">
                                    Bạn có thể gửi một lời ứng tuyển kèm tin nhắn giới thiệu năng lực đến học viên này để đề
                                    xuất nhận lớp dạy kèm.
                                </p>
                                <button type="button" onclick="openModal()"
                                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl text-sm font-bold transition shadow-sm hover:shadow-md">
                                    <i class="fas fa-paper-plane"></i> Gửi lời mời nhận lớp
                                </button>
                            </div>
                        @else
                            <div
                                class="p-4 bg-blue-50/50 border border-blue-100 rounded-xl text-center text-blue-700 text-xs font-semibold">
                                <i class="fas fa-check-circle mr-1"></i> Lớp học đã được giao cho gia sư thành công.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Interactive Schedule Section (Tutor Green theme) -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 md:p-8 space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-100 pb-4">
                <div>
                    <h3 class="font-bold text-gray-800 text-lg flex items-center gap-2">
                        <i class="fas fa-calendar-alt text-green-600"></i> Lịch dạy & Thời khóa biểu
                    </h3>
                    <p class="text-xs text-gray-400 mt-0.5">Theo dõi lịch dạy dự kiến theo từng tuần học.</p>
                </div>

                <!-- Week Changer Widget -->
                <div class="flex items-center gap-2">
                    <button @click="if (currentWeek > 1) currentWeek--" :disabled="currentWeek === 1"
                        class="w-9 h-9 rounded-xl border border-gray-200 flex items-center justify-center hover:bg-gray-50 transition disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas fa-chevron-left text-xs text-gray-600"></i>
                    </button>
                    <div
                        class="px-4 py-1.5 bg-green-50 border border-green-100 rounded-xl text-sm font-bold text-green-700 whitespace-nowrap">
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
                            'bg-green-600 text-white shadow-sm' :
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
                            '{{ $isScheduled ? 'bg-linear-to-br from-green-500 to-emerald-600 text-white shadow-md border-transparent transform scale-[1.02]' : 'bg-white border-gray-100 text-gray-500' }}' :
                            '{{ $isScheduled ? 'bg-linear-to-br from-emerald-500 to-teal-600 text-white shadow-md border-transparent transform scale-[1.02]' : 'bg-white border-gray-100 text-gray-500' }}'">

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
                                    <i class="fas fa-check-circle text-white"></i> Lịch dạy
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

    <!-- Modal Gửi lời mời/Ứng tuyển -->
    @if ($class->status !== 'assigned')
        <div id="inviteModal"
            class="fixed inset-0 bg-black/60 hidden flex items-center justify-center z-50 p-4 transition-all duration-300">
            <div class="bg-white w-full max-w-md rounded-2xl shadow-xl overflow-hidden transform transition-all">
                <div
                    class="px-6 py-4 bg-linear-to-r from-green-600 to-emerald-600 text-white flex justify-between items-center">
                    <h3 class="font-bold text-lg">Ứng tuyển nhận lớp dạy kèm</h3>
                    <button type="button" onclick="closeModal()" class="text-white hover:text-gray-200 transition">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>

                <form method="POST" action="{{ route('tutor.classes.invite', $class->id) }}" class="p-6 space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Tin nhắn giới thiệu năng lực / Lời nhắn
                        </label>
                        <textarea name="message" rows="4"
                            class="w-full border border-gray-200 rounded-xl p-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-500 transition resize-none"
                            placeholder="Hãy ghi lời nhắn ngắn gọn giới thiệu học vị, kinh nghiệm liên quan của bạn cho phụ huynh/học viên..."></textarea>
                    </div>

                    <div class="flex justify-end gap-3 pt-2">
                        <button type="button" onclick="closeModal()"
                            class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-semibold text-sm transition">
                            Đóng
                        </button>
                        <button type="submit"
                            class="px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-xl font-semibold text-sm transition shadow-sm hover:shadow-md">
                            Gửi lời mời
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <script>
        const modal = document.getElementById('inviteModal');

        function openModal() {
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        }

        function closeModal() {
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }

        window.onclick = function(e) {
            if (e.target === modal) {
                closeModal();
            }
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    </script>
@endsection
