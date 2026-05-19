@extends('student.classes.create')
@php
    $allSubjects = $subjects->unique('id');
@endphp
@section('title', 'Bước 1: Chọn ngành và môn học')
@section('step-content')
    <form action="{{ route('create-class.post.step1') }}" method="POST">
        @csrf

        {{-- NGÀNH HỌC --}}
        <div class="mb-10">
            <h2 class="text-lg font-semibold mb-4">Chọn ngành học</h2>
            <div class="grid grid-cols-5 gap-4">
                @foreach ($grades as $grade)
                    <x-form.radio name="grade_id" :label="$grade->name" :value="$grade->id" :checked="old('grade_id') == $grade->id" />
                @endforeach

                {{-- Khác --}}
                <label class="flex items-center gap-3 cursor-pointer col-span-5">
                    <input type="radio" name="grade_id" value="other" id="grade_other_radio"
                        {{ old('grade_id') == 'other' ? 'checked' : '' }}
                        class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300">

                    <span for="grade_other_radio">Khác:</span>

                    <input type="text" id="grade_other_input" name="grade_request" value="{{ old('grade_request') }}"
                        placeholder="Nhập ngành học..."
                        class="border rounded-lg px-3 py-2 w-64 focus:ring-2 focus:ring-blue-500 focus:outline-none hidden transition-all duration-300 ease-in-out">
                </label>
            </div>
        </div>

        {{-- MÔN HỌC --}}
        <div class="mb-10">
            <h2 class="text-lg font-semibold mb-4">Chọn môn học</h2>

            <div id="subjects-container" class="grid grid-cols-5 gap-4">
                @foreach ($allSubjects as $subject)
                    <div class="subject-item hidden" data-grades="{{ $subject->grades->pluck('id')->join(',') }}">
                        <x-form.radio name="subject_id" :label="$subject->name" :value="$subject->id" />
                    </div>
                @endforeach
                {{-- Khác --}}
                <label class="flex items-center gap-3 cursor-pointer col-span-5">
                    <input type="radio" name="subject_id" value="other" id="subject_other_radio"
                        {{ old('subject_id') == 'other' ? 'checked' : '' }}
                        class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300">

                    <span>Khác:</span>

                    <input type="text" id="subject_other_input" name="subject_request"
                        value="{{ old('subject_request') }}" placeholder="Nhập môn học..."
                        class="border rounded-lg px-3 py-2 w-64 focus:ring-2 focus:ring-blue-500 focus:outline-none hidden transition-all duration-300 ease-in-out">
                </label>

            </div>
        </div>

        {{-- NÚT NEXT --}}
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition">
                Tiếp theo →
            </button>
        </div>
    </form>

    {{-- JS: hiển thị input "Khác" khi radio được chọn --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function toggleOtherInput(radioId, inputId) {
                const radio = document.getElementById(radioId);
                const input = document.getElementById(inputId);

                // Khởi tạo hiển thị
                if (radio.checked) {
                    input.classList.remove('hidden');
                } else {
                    input.classList.add('hidden');
                }

                radio.addEventListener('change', function() {
                    if (radio.checked) {
                        input.classList.remove('hidden');
                        input.focus();
                    } else {
                        input.classList.add('hidden');
                        input.value = '';
                    }
                });

                // Ẩn input nếu user chọn radio khác (cùng group)
                const groupName = radio.name;
                const otherRadios = document.querySelectorAll(`input[name="${groupName}"]:not(#${radioId})`);
                otherRadios.forEach(r => {
                    r.addEventListener('change', function() {
                        if (input.value && r.checked) {
                            input.classList.add('hidden');
                            input.value = '';
                        }
                    });
                });
            }

            toggleOtherInput('grade_other_radio', 'grade_other_input');
            toggleOtherInput('subject_other_radio', 'subject_other_input');
        });

        document.addEventListener('DOMContentLoaded', function() {

            const gradeRadios = document.querySelectorAll('input[name="grade_id"]');
            const subjectItems = document.querySelectorAll('.subject-item');

            function showAllSubjects() {
                subjectItems.forEach(item => {
                    item.classList.remove('hidden');
                });
            }

            function filterSubjectsByGrade(gradeId) {
                subjectItems.forEach(item => {
                    const grades = item.dataset.grades.split(','); // 👈 đúng key

                    if (grades.includes(String(gradeId))) {
                        item.classList.remove('hidden');
                    } else {
                        item.classList.add('hidden');
                    }
                });
            }

            gradeRadios.forEach(radio => {
                radio.addEventListener('change', function() {

                    // reset chọn môn
                    document.querySelectorAll('input[name="subject_id"]').forEach(r => {
                        r.checked = false;
                    });

                    if (this.value === 'other') {
                        // 🌈 Khác → hiện tất cả môn
                        showAllSubjects();
                    } else {
                        // 🎯 ngành có sẵn → lọc theo ngành
                        filterSubjectsByGrade(this.value);
                    }
                });
            });

            // khởi tạo khi có old()
            const checkedGrade = document.querySelector('input[name="grade_id"]:checked');

            if (checkedGrade) {
                if (checkedGrade.value === 'other') {
                    showAllSubjects();
                } else {
                    filterSubjectsByGrade(checkedGrade.value);
                }
            }
        });
    </script>
@endsection
