@extends('student.classes.create')
@php
    $oldSchedule = old('schedule', $data['schedule'] ?? []);
@endphp
@section('title', 'Bước 4: Thời gian học')
@section('step-content')
    <form action="{{ route('create-class.post.step4') }}" method="POST">
        @csrf

        <div class="space-y-8">

            {{-- Số tuần --}}
            <div>
                <label class="font-semibold block mb-2">Số tuần học</label>
                <select name="weeks" class="w-full border rounded-lg px-4 py-2">
                    <option value="">Chọn số tuần</option>

                    @foreach (['1 tuần', '2 tuần', '3 tuần', '4 tuần', '5 tuần', '6 tuần'] as $week)
                        <option value="{{ $week }}"
                            {{ old('weeks', $data['weeks'] ?? '') == $week ? 'selected' : '' }}>
                            {{ $week }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Ngày học --}}
            <div>
                <label class="font-semibold block mb-3">Ngày học</label>

                <div class="flex flex-wrap gap-4">
                    @foreach (['T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'CN'] as $day)
                        <label class="flex items-center gap-2 px-3 py-2 rounded-lg cursor-pointer hover:bg-gray-100">
                            <input type="checkbox" name="schedule[]" value="{{ $day }}"
                                {{ in_array($day, $oldSchedule) ? 'checked' : '' }}>

                            {{ $day }}
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Khung giờ --}}
            <div>
                <label class="font-semibold block mb-3">Khung giờ học</label>

                <div class="flex items-center gap-4">
                    <input type="time" name="time_start" value="{{ old('time_start', $data['time_start'] ?? '') }}"
                        class="border rounded-lg px-4 py-2">

                    <span class="font-semibold">-</span>

                    <input type="time" name="time_end" value="{{ old('time_end', $data['time_end'] ?? '') }}"
                        class="border rounded-lg px-4 py-2">
                </div>
            </div>

        </div>

        <div class="flex justify-between mt-10">
            <a href="{{ route('create-class.step3') }}" class="px-6 py-2 border rounded-lg hover:bg-gray-100">
                ← Quay lại
            </a>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                Tiếp theo →
            </button>
        </div>
    </form>
@endsection
