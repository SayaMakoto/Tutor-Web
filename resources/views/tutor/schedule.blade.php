@extends($layout)

@section('title', 'Lịch dạy')

@section('content')
    <div class="max-w-6xl mx-auto">

        {{-- Page Header --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Lịch dạy</h1>
            <p class="text-sm text-gray-500 mt-1">Quản lý lịch trình giảng dạy của bạn</p>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">

            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 bg-green-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-chalkboard-teacher text-green-600 text-lg"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-800">{{ $activeClasses->count() }}</p>
                        <p class="text-xs text-gray-500">Lớp đang dạy</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 bg-emerald-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-calendar-check text-emerald-600 text-lg"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-800">{{ $totalSessionsPerWeek }}</p>
                        <p class="text-xs text-gray-500">Buổi dạy / tuần</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 bg-teal-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-clock text-teal-600 text-lg"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-800">{{ round($totalHoursPerWeek, 1) }}</p>
                        <p class="text-xs text-gray-500">Giờ dạy / tuần</p>
                    </div>
                </div>
            </div>

        </div>


        {{-- Weekly Calendar --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-8">

            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold text-gray-800">Lịch tuần</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Tổng quan lịch dạy trong tuần</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 text-xs text-gray-500">
                        <span class="w-2 h-2 rounded-full bg-green-500"></span> Đang dạy
                    </span>
                    <span class="inline-flex items-center gap-1.5 text-xs text-gray-500">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Hoàn thành
                    </span>
                    <span class="inline-flex items-center gap-1.5 text-xs text-gray-500">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span> Chờ thanh toán
                    </span>
                </div>
            </div>

            @php
                $dayLabels = [
                    'monday'    => 'Thứ 2',
                    'tuesday'   => 'Thứ 3',
                    'wednesday' => 'Thứ 4',
                    'thursday'  => 'Thứ 5',
                    'friday'    => 'Thứ 6',
                    'saturday'  => 'Thứ 7',
                    'sunday'    => 'CN',
                ];

                $dayShort = [
                    'monday'    => 'T2',
                    'tuesday'   => 'T3',
                    'wednesday' => 'T4',
                    'thursday'  => 'T5',
                    'friday'    => 'T6',
                    'saturday'  => 'T7',
                    'sunday'    => 'CN',
                ];

                $today = now()->locale('vi');
                $todayKey = strtolower($today->format('l'));
            @endphp

            {{-- Desktop Calendar --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr>
                            @foreach ($dayLabels as $key => $label)
                                <th class="px-3 py-3 text-center text-xs font-semibold uppercase tracking-wider
                                           {{ $key === $todayKey ? 'bg-green-50 text-green-700' : 'text-gray-400 bg-gray-50/50' }}
                                           border-b border-gray-100"
                                    style="width: 14.28%">
                                    <span>{{ $label }}</span>
                                    @if ($key === $todayKey)
                                        <span class="ml-1 inline-flex w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                    @endif
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach ($dayLabels as $key => $label)
                                <td class="align-top p-2 border-r border-gray-50 last:border-r-0
                                           {{ $key === $todayKey ? 'bg-green-50/30' : '' }}"
                                    style="min-height: 120px; vertical-align: top;">

                                    @if (count($scheduleByDay[$key]) > 0)
                                        <div class="flex flex-col gap-2">
                                            @foreach ($scheduleByDay[$key] as $event)
                                                <a href="#class-{{ $event['class_id'] }}"
                                                   onclick="highlightClass('class-{{ $event['class_id'] }}')"
                                                   class="block p-2.5 rounded-xl border transition-all duration-200
                                                          hover:shadow-md hover:-translate-y-0.5 cursor-pointer
                                                          {{ $event['color']['bg'] }} {{ $event['color']['border'] }}">

                                                    <div class="flex items-center gap-1.5 mb-1.5">
                                                        <span class="w-2 h-2 rounded-full {{ $event['color']['dot'] }}"></span>
                                                        <span class="text-xs font-bold {{ $event['color']['text'] }} truncate">
                                                            {{ $event['subject'] }}
                                                        </span>
                                                    </div>

                                                    <div class="flex items-center gap-1 text-[10px] text-gray-500 mb-1">
                                                        <i class="fas fa-clock"></i>
                                                        <span>{{ $event['start_time'] }} - {{ $event['end_time'] }}</span>
                                                    </div>

                                                    <div class="flex items-center justify-between">
                                                        <span class="inline-flex items-center gap-1 text-[10px]
                                                            {{ $event['study_type'] === 'online'
                                                                ? 'text-blue-600'
                                                                : 'text-orange-600' }}">
                                                            <i class="fas {{ $event['study_type'] === 'online' ? 'fa-video' : 'fa-map-marker-alt' }}"></i>
                                                            {{ $event['study_type'] === 'online' ? 'Online' : 'Offline' }}
                                                        </span>

                                                        @if ($event['status'] === 'active')
                                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500" title="Đang dạy"></span>
                                                        @elseif ($event['status'] === 'completed')
                                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400" title="Hoàn thành"></span>
                                                        @else
                                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-400" title="Chờ thanh toán"></span>
                                                        @endif
                                                    </div>

                                                </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="h-20 flex items-center justify-center">
                                            <span class="text-[10px] text-gray-300">Trống</span>
                                        </div>
                                    @endif

                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Mobile Calendar --}}
            <div class="md:hidden p-4">
                <div class="flex flex-col gap-3">
                    @foreach ($dayLabels as $key => $label)
                        @if (count($scheduleByDay[$key]) > 0)
                            <div class="rounded-xl {{ $key === $todayKey ? 'bg-green-50/50 ring-1 ring-green-200' : 'bg-gray-50' }} p-3">
                                <div class="flex items-center gap-2 mb-2.5">
                                    <span class="text-sm font-bold {{ $key === $todayKey ? 'text-green-700' : 'text-gray-700' }}">
                                        {{ $label }}
                                    </span>
                                    @if ($key === $todayKey)
                                        <span class="text-[10px] bg-green-100 text-green-600 px-2 py-0.5 rounded-full font-medium">Hôm nay</span>
                                    @endif
                                    <span class="text-[10px] text-gray-400 ml-auto">{{ count($scheduleByDay[$key]) }} buổi</span>
                                </div>

                                <div class="flex flex-col gap-2">
                                    @foreach ($scheduleByDay[$key] as $event)
                                        <a href="#class-{{ $event['class_id'] }}"
                                           onclick="highlightClass('class-{{ $event['class_id'] }}')"
                                           class="flex items-center gap-3 p-3 rounded-xl bg-white border {{ $event['color']['border'] }}
                                                  hover:shadow-sm transition">
                                            <div class="w-1 h-10 rounded-full {{ $event['color']['dot'] }}"></div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-semibold {{ $event['color']['text'] }} truncate">{{ $event['subject'] }}</p>
                                                <p class="text-xs text-gray-400 mt-0.5">
                                                    <i class="fas fa-clock mr-1"></i>{{ $event['start_time'] }} - {{ $event['end_time'] }}
                                                    <span class="mx-1">·</span>
                                                    {{ $event['study_type'] === 'online' ? 'Online' : 'Offline' }}
                                                </p>
                                            </div>
                                            <i class="fas fa-chevron-right text-gray-300 text-xs"></i>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach

                    @if (collect($scheduleByDay)->flatten(1)->isEmpty())
                        <div class="text-center py-10 bg-white rounded-2xl border border-dashed border-gray-200">
                            <i class="fas fa-calendar-xmark text-gray-300 text-4xl mb-3"></i>
                            <p class="text-gray-500 font-medium">Chưa có lịch dạy nào</p>
                            <p class="text-gray-400 text-sm mt-1">Hãy nhận lớp để bắt đầu!</p>
                            <a href="{{ route('tutor.classes.index') }}"
                               class="inline-flex items-center gap-2 mt-4 bg-green-600 text-white text-sm font-semibold px-5 py-2.5 rounded-xl hover:bg-green-700 transition shadow-sm">
                                <i class="fas fa-search"></i> Tìm lớp
                            </a>
                        </div>
                    @endif
                </div>
            </div>

        </div>


        {{-- Class Detail List --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-lg font-bold text-gray-800">Chi tiết lớp dạy</h2>
                <p class="text-xs text-gray-400 mt-0.5">Thông tin chi tiết từng lớp và lịch học</p>
            </div>

            @if ($tutorClasses->isEmpty())
                <div class="text-center py-14">
                    <i class="fas fa-calendar-xmark text-gray-300 text-4xl mb-3"></i>
                    <p class="text-gray-500 font-medium">Chưa có lớp nào</p>
                    <p class="text-gray-400 text-sm mt-1">Hãy nhận lớp để bắt đầu giảng dạy!</p>
                    <a href="{{ route('tutor.classes.index') }}"
                       class="inline-flex items-center gap-2 mt-4 bg-green-600 text-white text-sm font-semibold px-5 py-2.5 rounded-xl hover:bg-green-700 transition shadow-sm">
                        <i class="fas fa-search"></i> Tìm lớp ngay
                    </a>
                </div>
            @else
                <div class="divide-y divide-gray-50">
                    @foreach ($tutorClasses as $tc)
                        @php $cr = $tc->classRequest; @endphp
                        @if ($cr)
                            <div id="class-{{ $cr->id }}" class="p-5 hover:bg-gray-50/50 transition duration-500 rounded-xl">
                                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">

                                    {{-- Left: Class Info --}}
                                    <div class="flex items-start gap-4">
                                        <div class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0
                                                    {{ $tc->status === 'active' ? 'bg-green-100' : ($tc->status === 'completed' ? 'bg-emerald-100' : 'bg-amber-100') }}">
                                            <i class="fas fa-book
                                                      {{ $tc->status === 'active' ? 'text-green-600' : ($tc->status === 'completed' ? 'text-emerald-600' : 'text-amber-600') }}"></i>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-800 text-sm">
                                                {{ $cr->subject->name ?? 'N/A' }}
                                                @if ($cr->grade)
                                                    <span class="text-gray-400 font-normal">— {{ $cr->grade->name }}</span>
                                                @endif
                                            </h3>
                                            <div class="flex flex-wrap items-center gap-x-4 gap-y-1 mt-1.5 text-xs text-gray-500">
                                                <span>
                                                    <i class="fas fa-money-bill-wave mr-1 text-green-500"></i>
                                                    {{ number_format($cr->fee) }}đ/giờ
                                                </span>
                                                <span>
                                                    <i class="fas {{ $cr->study_type === 'online' ? 'fa-video text-blue-500' : 'fa-map-marker-alt text-orange-500' }} mr-1"></i>
                                                    {{ $cr->study_type === 'online' ? 'Online' : 'Offline' }}
                                                </span>
                                                <span>
                                                    <i class="fas fa-calendar mr-1 text-gray-400"></i>
                                                    {{ $cr->schedules->count() }} buổi/tuần
                                                </span>
                                            </div>

                                            {{-- Schedule pills --}}
                                            <div class="flex flex-wrap gap-1.5 mt-2">
                                                @foreach ($cr->schedules as $sch)
                                                    <span class="inline-flex items-center gap-1 bg-gray-100 text-gray-600
                                                                 text-[10px] px-2 py-1 rounded-lg font-medium">
                                                        <i class="fas fa-clock text-gray-400"></i>
                                                        {{ $sch->day_of_week }}
                                                        {{ \Carbon\Carbon::parse($sch->start_time)->format('H:i') }}–{{ \Carbon\Carbon::parse($sch->end_time)->format('H:i') }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Right: Status + Action --}}
                                    <div class="flex items-center gap-3 md:flex-col md:items-end">
                                        <span class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-full
                                                    {{ $tc->status_color }}">
                                            @if ($tc->status === 'active')
                                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                            @endif
                                            {{ $tc->status_label }}
                                        </span>
                                        <a href="{{ route('tutor.classes.show', $cr->id) }}"
                                           class="text-xs text-green-600 hover:text-green-700 font-medium transition">
                                            Chi tiết <i class="fas fa-arrow-right ml-0.5"></i>
                                        </a>
                                    </div>

                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif

        </div>

    </div>
@endsection

@push('scripts')
<script>
    document.documentElement.style.scrollBehavior = 'smooth';

    function highlightClass(id) {
        const el = document.getElementById(id);
        if (el) {
            // Remove previous highlights
            document.querySelectorAll('[id^="class-"]').forEach(item => {
                item.classList.remove('bg-green-50/80', 'ring-2', 'ring-green-400');
            });
            
            // Add highlight
            el.classList.add('bg-green-50/80', 'ring-2', 'ring-green-400');
            
            // Remove highlight after 2s
            setTimeout(() => {
                el.classList.remove('bg-green-50/80', 'ring-2', 'ring-green-400');
            }, 2000);
        }
    }
</script>
@endpush
