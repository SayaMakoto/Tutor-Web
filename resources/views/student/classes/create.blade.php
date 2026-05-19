@php
    $step = $step ?? 1;
@endphp

@extends('layouts.student')

@section('content')
    <div class="min-h-screen bg-gray-50 py-10">
        <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-2xl p-8">

            {{-- STEP PROGRESS --}}
            <div class="flex items-center justify-between mb-10">

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
                    <div class="flex flex-col items-center relative flex-1">
                        {{-- Step circle --}}
                        <div
                            class="w-10 h-10 flex items-center justify-center rounded-full 
                        {{ $step == $key ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-600' }}">
                            {{ $key }}
                        </div>
                        {{-- Label dưới nút --}}
                        <p class="mt-2 text-sm {{ $step == $key ? 'text-blue-600 font-medium' : 'text-gray-500' }}">
                            {{ $label }}
                        </p>

                        {{-- Arrow to next step --}}
                        @if ($key != count($steps))
                            <div class="absolute top-2 right-[-50%] w-full flex justify-center">
                                <span class="text-gray-400 font-bold">→</span>
                            </div>
                        @endif
                    </div>
                @endforeach

            </div>

            {{-- STEP CONTENT --}}
            @yield('step-content')

        </div>
    </div>
@endsection
