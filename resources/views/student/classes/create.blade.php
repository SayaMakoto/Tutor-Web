@php
    $step = $step ?? 1;
@endphp

@extends($layout)

@section('content')
    <div class="min-h-screen bg-gray-50/50 py-10">
        <div class="max-w-4xl mx-auto bg-white shadow-sm border border-gray-100 rounded-2xl p-6 md:p-10">

            {{-- STEP PROGRESS --}}
            <div class="relative flex items-center justify-between mb-12 max-w-3xl mx-auto px-4 select-none">
                <!-- Background progress bar line -->
                <div class="absolute left-8 top-5 right-8 h-0.5 bg-gray-150 z-0">
                    <div class="h-full bg-blue-600 transition-all duration-300" style="width: {{ (($step - 1) / 4) * 100 }}%">
                    </div>
                </div>

                @php
                    $steps = [
                        1 => 'Môn học',
                        2 => 'Yêu cầu gia sư',
                        3 => 'Địa điểm',
                        4 => 'Lịch học',
                        5 => 'Xác nhận',
                    ];
                @endphp

                @foreach ($steps as $key => $label)
                    <div class="flex flex-col items-center relative z-10">
                        {{-- Step circle --}}
                        <div
                            class="w-10 h-10 flex items-center justify-center rounded-full font-bold text-xs border-2 transition-all duration-300 
                            {{ $step > $key ? 'bg-blue-600 border-blue-600 text-white shadow-sm' : ($step == $key ? 'bg-white border-blue-600 text-blue-600 shadow-md ring-4 ring-blue-50' : 'bg-white border-gray-200 text-gray-400') }}">
                            @if ($step > $key)
                                <i class="fas fa-check"></i>
                            @else
                                {{ $key }}
                            @endif
                        </div>
                        {{-- Label dưới nút --}}
                        <p
                            class="mt-2.5 text-[11px] font-bold uppercase tracking-wider text-center {{ $step == $key ? 'text-blue-600' : 'text-gray-400' }}">
                            {{ $label }}
                        </p>
                    </div>
                @endforeach
            </div>

            {{-- STEP CONTENT --}}
            <div class="mt-8">
                @yield('step-content')
            </div>

        </div>
    </div>
@endsection
