@php
    $fee = old('fee', $data['fee'] ?? 150000);
@endphp

@extends('student.classes.create')
@section('title', 'Bước 2: Yêu cầu gia sư')
@section('step-content')
    <form action="{{ route('create-class.post.step2') }}" method="POST" class="space-y-8">
        @csrf

        {{-- TÓM TẮT STEP 1 --}}
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-100/70 rounded-2xl p-5 mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h4 class="text-[11px] font-bold uppercase tracking-wider text-blue-600/80 mb-2">Thông tin đã chọn ở Bước 1</h4>
                <div class="flex flex-wrap gap-2.5">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white border border-blue-100 text-xs font-semibold text-blue-800 shadow-sm">
                        <i class="fas fa-graduation-cap text-blue-500"></i>
                        {{ $data['grade_name'] ?? $data['grade_request'] }}
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white border border-blue-100 text-xs font-semibold text-indigo-800 shadow-sm">
                        <i class="fas fa-book text-indigo-500"></i>
                        {{ $data['subject_name'] ?? $data['subject_request'] }}
                    </span>
                </div>
            </div>
        </div>

        {{-- CÁC TIÊU CHÍ TUYỂN DỤNG --}}
        <div class="space-y-6">
            <h3 class="text-base font-bold text-gray-800 mb-4 flex items-center gap-2">
                <span class="w-6 h-6 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xs font-bold">1</span>
                Thiết lập yêu cầu gia sư
            </h3>

            {{-- Grid Trình độ, Kinh nghiệm, Độ tuổi --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Trình độ --}}
                <div>
                    <label class="font-bold text-xs text-gray-600 block mb-2 uppercase tracking-wide">Trình độ học vấn</label>
                    <div class="relative">
                        <select name="degree" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:outline-none transition-all cursor-pointer appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2020%2020%2522%20fill%3D%22none%22%3E%3Cpath%20d%3D%22M7%209l3%203%203-3%22%20stroke%3D%22%236b7280%22%20stroke-width%3D%221.5%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%2F%3E%3C%2Fsvg%3E')] bg-[size:1.25rem_1.25rem] bg-[position:right_1rem_center] bg-no-repeat pr-10">
                            <option value="">-- Chọn trình độ --</option>
                            <option value="Cao đẳng" {{ old('degree', $data['degree'] ?? '') == 'Cao đẳng' ? 'selected' : '' }}>Cao đẳng</option>
                            <option value="Đại học" {{ old('degree', $data['degree'] ?? '') == 'Đại học' ? 'selected' : '' }}>Đại học</option>
                            <option value="Nghề" {{ old('degree', $data['degree'] ?? '') == 'Nghề' ? 'selected' : '' }}>Nghề</option>
                            <option value="Không yêu cầu" {{ old('degree', $data['degree'] ?? '') == 'Không yêu cầu' ? 'selected' : '' }}>Không yêu cầu</option>
                        </select>
                    </div>
                    @error('degree')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                    @enderror
                </div>

                {{-- Kinh nghiệm --}}
                <div>
                    <label class="font-bold text-xs text-gray-600 block mb-2 uppercase tracking-wide">Kinh nghiệm dạy kèm</label>
                    <div class="relative">
                        <select name="experience" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:outline-none transition-all cursor-pointer appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2020%2020%2522%20fill%3D%22none%22%3E%3Cpath%20d%3D%22M7%209l3%203%203-3%22%20stroke%3D%22%236b7280%22%20stroke-width%3D%221.5%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%2F%3E%3C%2Fsvg%3E')] bg-[size:1.25rem_1.25rem] bg-[position:right_1rem_center] bg-no-repeat pr-10">
                            <option value="">-- Chọn kinh nghiệm --</option>
                            <option value="Sinh viên dạy kèm" {{ old('experience', $data['experience'] ?? '') == 'Sinh viên dạy kèm' ? 'selected' : '' }}>Sinh viên dạy kèm</option>
                            <option value="Giáo viên" {{ old('experience', $data['experience'] ?? '') == 'Giáo viên' ? 'selected' : '' }}>Giáo viên</option>
                            <option value="Không yêu cầu" {{ old('experience', $data['experience'] ?? '') == 'Không yêu cầu' ? 'selected' : '' }}>Không yêu cầu</option>
                        </select>
                    </div>
                    @error('experience')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                    @enderror
                </div>

                {{-- Độ tuổi --}}
                <div>
                    <label class="font-bold text-xs text-gray-600 block mb-2 uppercase tracking-wide">Độ tuổi yêu cầu</label>
                    <div class="relative">
                        <select name="age_range" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:outline-none transition-all cursor-pointer appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2020%2020%2522%20fill%3D%22none%22%3E%3Cpath%20d%3D%22M7%209l3%203%203-3%22%20stroke%3D%22%236b7280%22%20stroke-width%3D%221.5%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%2F%3E%3C%2Fsvg%3E')] bg-[size:1.25rem_1.25rem] bg-[position:right_1rem_center] bg-no-repeat pr-10">
                            <option value="">-- Chọn độ tuổi --</option>
                            <option value="18-25" {{ old('age_range', $data['age_range'] ?? '') == '18-25' ? 'selected' : '' }}>18 - 25</option>
                            <option value="26-35" {{ old('age_range', $data['age_range'] ?? '') == '26-35' ? 'selected' : '' }}>26 - 35</option>
                            <option value="Không yêu cầu" {{ old('age_range', $data['age_range'] ?? '') == 'Không yêu cầu' ? 'selected' : '' }}>Không yêu cầu</option>
                        </select>
                    </div>
                    @error('age_range')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Giới tính (Premium Card Radio) --}}
            <div>
                <label class="font-bold text-xs text-gray-600 block mb-3 uppercase tracking-wide">Yêu cầu giới tính</label>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    {{-- Nam --}}
                    <label class="flex items-center justify-between p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-blue-300 hover:bg-blue-50/10 transition relative group select-none">
                        <input type="radio" name="gender" value="male" class="sr-only peer" {{ old('gender', $data['gender'] ?? 'no_need') == 'male' ? 'checked' : '' }}>
                        <div class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-blue-600 peer-checked:bg-blue-50/5 pointer-events-none transition-all"></div>
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-lg bg-blue-50 text-blue-500 flex items-center justify-center text-sm font-semibold peer-checked:bg-blue-100">
                                <i class="fas fa-mars"></i>
                            </span>
                            <span class="text-sm font-semibold text-gray-700 peer-checked:text-blue-600 transition">Nam</span>
                        </div>
                        <div class="w-4 h-4 rounded-full border border-gray-300 flex items-center justify-center peer-checked:border-blue-600 peer-checked:bg-blue-600 transition-all shrink-0">
                            <div class="w-1.5 h-1.5 rounded-full bg-white scale-0 peer-checked:scale-100 transition-all"></div>
                        </div>
                    </label>

                    {{-- Nữ --}}
                    <label class="flex items-center justify-between p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-blue-300 hover:bg-blue-50/10 transition relative group select-none">
                        <input type="radio" name="gender" value="female" class="sr-only peer" {{ old('gender', $data['gender'] ?? 'no_need') == 'female' ? 'checked' : '' }}>
                        <div class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-blue-600 peer-checked:bg-blue-50/5 pointer-events-none transition-all"></div>
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-lg bg-pink-50 text-pink-500 flex items-center justify-center text-sm font-semibold peer-checked:bg-pink-100">
                                <i class="fas fa-venus"></i>
                            </span>
                            <span class="text-sm font-semibold text-gray-700 peer-checked:text-blue-600 transition">Nữ</span>
                        </div>
                        <div class="w-4 h-4 rounded-full border border-gray-300 flex items-center justify-center peer-checked:border-blue-600 peer-checked:bg-blue-600 transition-all shrink-0">
                            <div class="w-1.5 h-1.5 rounded-full bg-white scale-0 peer-checked:scale-100 transition-all"></div>
                        </div>
                    </label>

                    {{-- Không yêu cầu --}}
                    <label class="flex items-center justify-between p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-blue-300 hover:bg-blue-50/10 transition relative group select-none">
                        <input type="radio" name="gender" value="no_need" class="sr-only peer" {{ old('gender', $data['gender'] ?? 'no_need') == 'no_need' ? 'checked' : '' }}>
                        <div class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-blue-600 peer-checked:bg-blue-50/5 pointer-events-none transition-all"></div>
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-lg bg-gray-50 text-gray-500 flex items-center justify-center text-sm font-semibold peer-checked:bg-gray-100">
                                <i class="fas fa-genderless"></i>
                            </span>
                            <span class="text-sm font-semibold text-gray-700 peer-checked:text-blue-600 transition">Không yêu cầu</span>
                        </div>
                        <div class="w-4 h-4 rounded-full border border-gray-300 flex items-center justify-center peer-checked:border-blue-600 peer-checked:bg-blue-600 transition-all shrink-0">
                            <div class="w-1.5 h-1.5 rounded-full bg-white scale-0 peer-checked:scale-100 transition-all"></div>
                        </div>
                    </label>
                </div>
                @error('gender')
                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                @enderror
            </div>

            {{-- Học phí mong muốn --}}
            <div>
                <h3 class="text-base font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xs font-bold">2</span>
                    Mức học phí mong muốn
                </h3>

                <div class="bg-gray-50/50 border border-gray-100 rounded-2xl p-6 space-y-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="space-y-1">
                            <label class="font-semibold text-sm text-gray-700 block">Nhập học phí (VNĐ / giờ)</label>
                            <p class="text-xs text-gray-400">Bạn có thể kéo thanh trượt bên dưới hoặc điền trực tiếp</p>
                        </div>
                        <div class="relative w-full sm:w-64">
                            <input type="number" id="feeInput" name="fee" value="{{ old('fee', $data['fee'] ?? 150000) }}"
                                class="w-full border border-gray-200 rounded-xl pl-4 pr-16 py-2.5 text-sm font-semibold text-blue-600 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:outline-none transition-all"
                                placeholder="Nhập số tiền">
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-bold text-gray-400">đ/giờ</span>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <input type="range" id="feeRange" min="0" max="2000000" step="50000" value="{{ old('fee', $data['fee'] ?? 150000) }}"
                            class="w-full h-1.5 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-blue-600 focus:outline-none">
                        <div class="flex justify-between text-[11px] font-bold text-gray-400 uppercase tracking-wider">
                            <span>0đ</span>
                            <span>1.000.000đ</span>
                            <span>2.000.000đ</span>
                        </div>
                    </div>

                    <div class="bg-blue-50/40 border border-blue-100/40 rounded-xl p-3.5 flex items-center justify-center gap-2">
                        <span class="text-sm font-medium text-gray-600">Mức phí đề xuất:</span>
                        <span id="feeDisplay" class="text-lg font-bold text-blue-600">150.000đ</span>
                        <span class="text-sm font-medium text-gray-500">/ giờ</span>
                    </div>
                </div>
                @error('fee')
                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                @enderror
            </div>

            {{-- Mô tả chi tiết --}}
            <div>
                <h3 class="text-base font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xs font-bold">3</span>
                    Mô tả chi tiết yêu cầu
                </h3>
                <textarea name="description" rows="4"
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:outline-none transition-all placeholder:text-gray-400"
                    placeholder="Ví dụ: Cần gia sư dạy chậm, dễ hiểu, ôn tập lý thuyết trước khi làm bài tập, hỗ trợ giải đáp bài thi học kỳ...">{{ old('description', $data['description'] ?? '') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- NÚT CHUYỂN BƯỚC --}}
        <div class="flex justify-between pt-6 border-t border-gray-100">
            <a href="{{ route('create-class.step1') }}" class="inline-flex items-center gap-2 px-6 py-3 border border-gray-200 rounded-xl font-semibold text-sm text-gray-600 hover:bg-gray-50 transition shadow-sm">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-semibold text-sm transition shadow-sm hover:shadow-md flex items-center gap-2">
                Tiếp theo <i class="fas fa-arrow-right"></i>
            </button>
        </div>
    </form>

    {{-- Script sync slider + input --}}
    <script>
        const feeRange = document.getElementById('feeRange');
        const feeInput = document.getElementById('feeInput');
        const feeDisplay = document.getElementById('feeDisplay');

        function formatMoney(value) {
            return new Intl.NumberFormat('vi-VN').format(value) + 'đ';
        }

        feeRange.addEventListener('input', function() {
            feeInput.value = this.value;
            feeDisplay.textContent = formatMoney(this.value);
        });

        feeInput.addEventListener('input', function() {
            feeRange.value = this.value;
            feeDisplay.textContent = formatMoney(this.value);
        });

        document.addEventListener('DOMContentLoaded', function() {
            const initialValue = feeInput.value || 150000;
            feeDisplay.textContent = formatMoney(initialValue);
            feeRange.value = initialValue;
        });
    </script>
@endsection

