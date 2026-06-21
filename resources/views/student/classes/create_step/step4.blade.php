@extends('student.classes.create')
@php
    $oldSchedule = old('schedule', $data['schedule'] ?? []);
    if (is_string($oldSchedule)) {
        $oldSchedule = explode(', ', $oldSchedule);
    }
@endphp
@section('title', 'Bước 4: Thời gian học')
@section('step-content')
    <form action="{{ route('create-class.post.step4') }}" method="POST" class="space-y-8">
        @csrf

        <div class="space-y-8">

            {{-- ĐỘ DÀI KHÓA HỌC (SỐ TUẦN/THÁNG) --}}
            <div>
                <h3 class="text-base font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xs font-bold">1</span>
                    Thời gian đào tạo mong muốn
                </h3>

                <!-- Input ẩn để gửi lên backend nhằm giữ nguyên name="weeks" và cơ chế lưu chuỗi -->
                <input type="hidden" name="weeks" id="weeks_hidden" value="{{ old('weeks', $data['weeks'] ?? '1 tuần') }}">

                <div class="flex items-center gap-3 max-w-md">
                    {{-- Ô nhập số --}}
                    <div class="relative flex-1">
                        <input type="number" id="weeks_val" min="1" max="100" value="1"
                            class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:outline-none transition-all font-semibold">
                    </div>

                    {{-- Nút chọn đơn vị --}}
                    <div class="flex border border-gray-200 rounded-xl p-1 bg-gray-50/50">
                        <button type="button" id="btn_unit_week" data-unit="tuần"
                            class="px-4 py-2 text-xs font-bold rounded-lg transition-all focus:outline-none bg-blue-600 text-white shadow-sm">
                            Tuần
                        </button>
                        <button type="button" id="btn_unit_month" data-unit="tháng"
                            class="px-4 py-2 text-xs font-bold rounded-lg transition-all focus:outline-none text-gray-500 hover:text-gray-700">
                            Tháng
                        </button>
                    </div>
                </div>
                
                @error('weeks')
                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-400 mt-2">Tổng thời gian mong muốn: <span id="weeks_summary" class="font-bold text-blue-600">1 tuần</span></p>
            </div>

            {{-- LỊCH HỌC TRONG TUẦN --}}
            <div>
                <h3 class="text-base font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xs font-bold">2</span>
                    Chọn ngày học trong tuần
                </h3>

                <div class="grid grid-cols-3 sm:grid-cols-7 gap-3">
                    @foreach (['T2' => 'Thứ 2', 'T3' => 'Thứ 3', 'T4' => 'Thứ 4', 'T5' => 'Thứ 5', 'T6' => 'Thứ 6', 'T7' => 'Thứ 7', 'CN' => 'Chủ Nhật'] as $val => $label)
                        <label class="flex flex-col items-center justify-center p-3.5 border border-gray-200 rounded-xl cursor-pointer hover:border-blue-300 hover:bg-blue-50/10 transition relative group select-none">
                            <input type="checkbox" name="schedule[]" value="{{ $val }}" class="sr-only peer"
                                {{ in_array($val, $oldSchedule) ? 'checked' : '' }}>
                            <div class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-blue-600 peer-checked:bg-blue-50/5 pointer-events-none transition-all"></div>
                            
                            <span class="text-xs text-gray-400 group-hover:text-gray-500 peer-checked:text-blue-500 transition mb-0.5">{{ $label }}</span>
                            <span class="text-sm font-bold text-gray-700 peer-checked:text-blue-600 transition">{{ $val }}</span>
                        </label>
                    @endforeach
                </div>
                
                @error('schedule')
                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                @enderror
            </div>

            {{-- KHUNG GIỜ HỌC --}}
            <div>
                <h3 class="text-base font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xs font-bold">3</span>
                    Khung giờ học mỗi buổi
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
                    {{-- Input giờ Start/End --}}
                    <div class="space-y-4">
                        <div class="flex items-center gap-4 bg-gray-50/50 border border-gray-150 rounded-2xl p-5">
                            <div class="flex-1 space-y-1">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide">Giờ bắt đầu</label>
                                <div class="relative">
                                    <input type="time" id="time_start" name="time_start" value="{{ old('time_start', $data['time_start'] ?? '') }}"
                                        class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-semibold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:outline-none transition-all">
                                </div>
                            </div>

                            <span class="font-bold text-gray-400 self-end mb-3.5">—</span>

                            <div class="flex-1 space-y-1">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide">Giờ kết thúc</label>
                                <div class="relative">
                                    <input type="time" id="time_end" name="time_end" value="{{ old('time_end', $data['time_end'] ?? '') }}"
                                        class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-semibold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:outline-none transition-all">
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            @error('time_start')
                                <p class="text-red-500 text-xs flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                            @enderror
                            @error('time_end')
                                <p class="text-red-500 text-xs flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Ca gợi ý nhanh --}}
                    <div>
                        <span class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-3">Gợi ý khung giờ nhanh</span>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <button type="button" class="preset-time-btn p-3 border border-gray-200 rounded-xl text-left hover:border-blue-400 hover:bg-blue-50/10 transition group focus:outline-none"
                                data-start="08:00" data-end="11:00">
                                <span class="block text-xs font-bold text-gray-700 group-hover:text-blue-600 transition">Ca Sáng</span>
                                <span class="block text-[11px] text-gray-400 mt-1">08:00 - 11:00</span>
                            </button>

                            <button type="button" class="preset-time-btn p-3 border border-gray-200 rounded-xl text-left hover:border-blue-400 hover:bg-blue-50/10 transition group focus:outline-none"
                                data-start="14:00" data-end="17:00">
                                <span class="block text-xs font-bold text-gray-700 group-hover:text-blue-600 transition">Ca Chiều</span>
                                <span class="block text-[11px] text-gray-400 mt-1">14:00 - 17:00</span>
                            </button>

                            <button type="button" class="preset-time-btn p-3 border border-gray-200 rounded-xl text-left hover:border-blue-400 hover:bg-blue-50/10 transition group focus:outline-none"
                                data-start="19:00" data-end="21:00">
                                <span class="block text-xs font-bold text-gray-700 group-hover:text-blue-600 transition">Ca Tối</span>
                                <span class="block text-[11px] text-gray-400 mt-1">19:00 - 21:00</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- NÚT CHUYỂN BƯỚC --}}
        <div class="flex justify-between pt-6 border-t border-gray-100">
            <a href="{{ route('create-class.step3') }}" class="inline-flex items-center gap-2 px-6 py-3 border border-gray-200 rounded-xl font-semibold text-sm text-gray-600 hover:bg-gray-50 transition shadow-sm">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-semibold text-sm transition shadow-sm hover:shadow-md flex items-center gap-2">
                Tiếp theo <i class="fas fa-arrow-right"></i>
            </button>
        </div>
    </form>

    {{-- Script đồng bộ weeks (số + đơn vị) và các ca giờ --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const weeksHidden = document.getElementById('weeks_hidden');
            const weeksVal = document.getElementById('weeks_val');
            const btnUnitWeek = document.getElementById('btn_unit_week');
            const btnUnitMonth = document.getElementById('btn_unit_month');
            const weeksSummary = document.getElementById('weeks_summary');

            let currentUnit = 'tuần';

            // Parse giá trị ban đầu của weeks_hidden
            const initVal = weeksHidden.value ? weeksHidden.value.trim() : '1 tuần';
            const match = initVal.match(/^(\d+)\s*(tuần|tháng)$/i);
            
            if (match) {
                weeksVal.value = parseInt(match[1]);
                currentUnit = match[2].toLowerCase();
            } else {
                weeksVal.value = 1;
                currentUnit = 'tuần';
            }

            // Cập nhật giao diện nút dựa trên đơn vị hiện tại
            function updateUnitUI() {
                if (currentUnit === 'tuần') {
                    btnUnitWeek.className = 'px-4 py-2 text-xs font-bold rounded-lg transition-all focus:outline-none bg-blue-600 text-white shadow-sm';
                    btnUnitMonth.className = 'px-4 py-2 text-xs font-bold rounded-lg transition-all focus:outline-none text-gray-500 hover:text-gray-700';
                } else {
                    btnUnitMonth.className = 'px-4 py-2 text-xs font-bold rounded-lg transition-all focus:outline-none bg-blue-600 text-white shadow-sm';
                    btnUnitWeek.className = 'px-4 py-2 text-xs font-bold rounded-lg transition-all focus:outline-none text-gray-500 hover:text-gray-700';
                }
                syncValue();
            }

            // Đồng bộ chuỗi gửi đi và text hiển thị
            function syncValue() {
                const num = weeksVal.value || 1;
                const result = `${num} ${currentUnit}`;
                weeksHidden.value = result;
                weeksSummary.textContent = result;
            }

            // Event listeners
            weeksVal.addEventListener('input', syncValue);
            weeksVal.addEventListener('change', syncValue);

            btnUnitWeek.addEventListener('click', function() {
                currentUnit = 'tuần';
                updateUnitUI();
            });

            btnUnitMonth.addEventListener('click', function() {
                currentUnit = 'tháng';
                updateUnitUI();
            });

            // Khởi tạo hiển thị lần đầu
            updateUnitUI();

            // Preset time buttons
            const presetButtons = document.querySelectorAll('.preset-time-btn');
            const timeStartInput = document.getElementById('time_start');
            const timeEndInput = document.getElementById('time_end');

            presetButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    timeStartInput.value = this.dataset.start;
                    timeEndInput.value = this.dataset.end;
                });
            });
        });
    </script>
@endsection
