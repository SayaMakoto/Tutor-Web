@php
    $fee = old('fee', $data['fee'] ?? 0);
@endphp

@extends('student.classes.create')
@section('title', 'Bước 2: Yêu cầu gia sư')
@section('step-content')
    <form action="{{ route('create-class.post.step2') }}" method="POST">
        @csrf

        {{-- TÓM TẮT STEP 1 --}}
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-8">
            <h3 class="font-semibold text-blue-700 mb-2">Thông tin đã chọn</h3>

            <p><strong>Ngành học:</strong> {{ $data['grade_name'] ?? $data['grade_request'] }}</p>
            <p><strong>Môn học:</strong> {{ $data['subject_name'] ?? $data['subject_request'] }}</p>
        </div>


        {{-- YÊU CẦU GIA SƯ --}}
        <div class="space-y-6">

            {{-- Trình độ --}}
            <div>
                <label class="font-semibold block mb-2">Trình độ</label>
                <select name="degree" class="w-full border rounded-lg px-4 py-2">
                    <option value="">-- Chọn trình độ --</option>

                    <option value="Cao đẳng" {{ old('degree', $data['degree'] ?? '') == 'Cao đẳng' ? 'selected' : '' }}>
                        Cao đẳng
                    </option>

                    <option value="Đại học" {{ old('degree', $data['degree'] ?? '') == 'Đại học' ? 'selected' : '' }}>
                        Đại học
                    </option>

                    <option value="Nghề" {{ old('degree', $data['degree'] ?? '') == 'Nghề' ? 'selected' : '' }}>
                        Nghề
                    </option>

                    <option value="Không yêu cầu"
                        {{ old('degree', $data['degree'] ?? '') == 'Không yêu cầu' ? 'selected' : '' }}>
                        Không yêu cầu
                    </option>
                </select>
            </div>

            {{-- Kinh nghiệm --}}
            <div>
                <label class="font-semibold block mb-2">Kinh nghiệm</label>
                <select name="experience" class="w-full border rounded-lg px-4 py-2">
                    <option value="">-- Chọn kinh nghiệm --</option>

                    <option value="Sinh viên dạy kèm"
                        {{ old('experience', $data['experience'] ?? '') == 'Sinh viên dạy kèm' ? 'selected' : '' }}>
                        Sinh viên dạy kèm
                    </option>

                    <option value="Giáo viên"
                        {{ old('experience', $data['experience'] ?? '') == 'Giáo viên' ? 'selected' : '' }}>
                        Giáo viên
                    </option>

                    <option value="Không yêu cầu"
                        {{ old('experience', $data['experience'] ?? '') == 'Không yêu cầu' ? 'selected' : '' }}>
                        Không yêu cầu
                    </option>
                </select>
            </div>

            {{-- Giới tính --}}
            <div>
                <label class="font-semibold block mb-2">Giới tính</label>
                <div class="flex gap-6">
                    <label>
                        <input type="radio" name="gender" value="male"
                            {{ old('gender', $data['gender'] ?? '') == 'male' ? 'checked' : '' }}>
                        Nam
                    </label>

                    <label>
                        <input type="radio" name="gender" value="female"
                            {{ old('gender', $data['gender'] ?? '') == 'female' ? 'checked' : '' }}>
                        Nữ
                    </label>

                    <label>
                        <input type="radio" name="gender" value="no_need"
                            {{ old('gender', $data['gender'] ?? '') == 'no_need' ? 'checked' : '' }}>
                        Không yêu cầu
                    </label>
                </div>
            </div>

            {{-- Độ tuổi --}}
            <div>
                <label class="font-semibold block mb-2">Độ tuổi</label>
                <select name="age_range" class="w-full border rounded-lg px-4 py-2">
                    <option value="">-- Chọn độ tuổi --</option>

                    <option value="18-25" {{ old('age_range', $data['age_range'] ?? '') == '18-25' ? 'selected' : '' }}>
                        18 - 25
                    </option>

                    <option value="26-35" {{ old('age_range', $data['age_range'] ?? '') == '26-35' ? 'selected' : '' }}>
                        26 - 35
                    </option>

                    <option value="Không yêu cầu"
                        {{ old('age_range', $data['age_range'] ?? '') == 'Không yêu cầu' ? 'selected' : '' }}>
                        Không yêu cầu
                    </option>
                </select>
            </div>

            {{-- Học phí --}}
            <div>
                <label class="font-semibold block mb-2">
                    Học phí mong muốn (đ/giờ)
                </label>

                <input type="number" id="feeInput" name="fee" value="{{ old('fee', $data['fee'] ?? '') }}"
                    class="w-full border rounded-lg px-4 py-2 mb-3" placeholder="Nhập học phí mong muốn">

                <input type="range" id="feeRange" min="0" max="2000000" step="50000" class="w-full">

                <!-- Mốc đầu và cuối -->
                <div class="flex justify-between text-sm text-gray-500 mt-1">
                    <span>0đ</span>
                    <span>2.000.000đ</span>
                </div>

                <!-- Hiển thị giá trị đang chọn -->
                <p class="text-center text-blue-600 font-medium mt-2">
                    Đang chọn: <span id="feeDisplay">0đ</span>
                </p>
            </div>

            {{-- Mô tả --}}
            <div>
                <label class="font-semibold block mb-2">Mô tả chi tiết</label>
                <textarea name="description" rows="4" class="w-full border rounded-lg px-4 py-2"
                    placeholder="Ví dụ: Cần gia sư dạy chậm, dễ hiểu, có kinh nghiệm luyện thi...">{{ old('description', $data['description'] ?? '') }}</textarea>
            </div>

        </div>


        {{-- BUTTONS --}}
        <div class="flex justify-between mt-10">
            <a href="{{ route('create-class.step1') }}" class="px-6 py-2 border rounded-lg hover:bg-gray-100">
                ← Quay lại
            </a>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                Tiếp theo →
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
            const initialValue = feeInput.value || 0;
            feeDisplay.textContent = formatMoney(initialValue);
            feeRange.value = initialValue;
        });
    </script>
@endsection
