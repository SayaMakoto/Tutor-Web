@extends('student.classes.create')
@php
    $allSubjects = $subjects->unique('id');
@endphp
@section('title', 'Bước 1: Chọn ngành và môn học')
@section('step-content')
    <form action="{{ route('create-class.post.step1') }}" method="POST" class="space-y-8">
        @csrf

        {{-- NGÀNH HỌC --}}
        <div>
            <h3 class="text-base font-bold text-gray-800 mb-4 flex items-center gap-2">
                <span class="w-6 h-6 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xs font-bold">1</span>
                Chọn ngành học của bạn
            </h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                @foreach ($grades as $grade)
                    <label class="flex items-center justify-between p-3.5 border border-gray-200 rounded-xl cursor-pointer hover:border-blue-300 hover:bg-blue-50/10 transition relative group select-none">
                        <input type="radio" name="grade_id" value="{{ $grade->id }}" class="sr-only peer" {{ old('grade_id') == $grade->id ? 'checked' : '' }}>
                        <div class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-blue-600 peer-checked:bg-blue-50/5 pointer-events-none transition-all"></div>
                        <span class="text-sm font-semibold text-gray-700 peer-checked:text-blue-600 transition">{{ $grade->name }}</span>
                        <div class="w-4 h-4 rounded-full border border-gray-300 flex items-center justify-center peer-checked:border-blue-600 peer-checked:bg-blue-600 transition-all shrink-0">
                            <div class="w-1.5 h-1.5 rounded-full bg-white scale-0 peer-checked:scale-100 transition-all"></div>
                        </div>
                    </label>
                @endforeach

                {{-- Khác --}}
                <label class="flex flex-col p-3.5 border border-gray-200 rounded-xl cursor-pointer hover:border-blue-300 hover:bg-blue-50/10 transition relative group select-none col-span-1 sm:col-span-2 md:col-span-3">
                    <div class="flex items-center justify-between w-full">
                        <div class="flex items-center gap-2">
                            <input type="radio" name="grade_id" value="other" id="grade_other_radio" class="sr-only peer" {{ old('grade_id') == 'other' ? 'checked' : '' }}>
                            <div class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-blue-600 peer-checked:bg-blue-50/5 pointer-events-none transition-all"></div>
                            <span class="text-sm font-semibold text-gray-700 peer-checked:text-blue-600 transition">Ngành học khác</span>
                        </div>
                        <div class="w-4 h-4 rounded-full border border-gray-300 flex items-center justify-center peer-checked:border-blue-600 peer-checked:bg-blue-600 transition-all shrink-0">
                            <div class="w-1.5 h-1.5 rounded-full bg-white scale-0 peer-checked:scale-100 transition-all"></div>
                        </div>
                    </div>
                    <div class="mt-3 w-full">
                        <input type="text" id="grade_other_input" name="grade_request" value="{{ old('grade_request') }}"
                            placeholder="Nhập tên ngành học khác..."
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 focus:outline-none hidden transition-all duration-300 ease-in-out">
                    </div>
                </label>
            </div>
        </div>

        {{-- MÔN HỌC --}}
        <div>
            <h3 class="text-base font-bold text-gray-800 mb-4 flex items-center gap-2">
                <span class="w-6 h-6 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xs font-bold">2</span>
                Chọn môn học tương ứng
            </h3>

            <div id="subjects-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                @foreach ($allSubjects as $subject)
                    <div class="subject-item hidden" data-grades="{{ $subject->grades->pluck('id')->join(',') }}">
                        <label class="flex items-center justify-between p-3.5 border border-gray-200 rounded-xl cursor-pointer hover:border-blue-300 hover:bg-blue-50/10 transition relative group select-none">
                            <input type="radio" name="subject_id" value="{{ $subject->id }}" class="sr-only peer" {{ old('subject_id') == $subject->id ? 'checked' : '' }}>
                            <div class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-blue-600 peer-checked:bg-blue-50/5 pointer-events-none transition-all"></div>
                            <span class="text-sm font-semibold text-gray-700 peer-checked:text-blue-600 transition">{{ $subject->name }}</span>
                            <div class="w-4 h-4 rounded-full border border-gray-300 flex items-center justify-center peer-checked:border-blue-600 peer-checked:bg-blue-600 transition-all shrink-0">
                                <div class="w-1.5 h-1.5 rounded-full bg-white scale-0 peer-checked:scale-100 transition-all"></div>
                            </div>
                        </label>
                    </div>
                @endforeach

                {{-- Khác --}}
                <label class="flex flex-col p-3.5 border border-gray-200 rounded-xl cursor-pointer hover:border-blue-300 hover:bg-blue-50/10 transition relative group select-none col-span-1 sm:col-span-2 md:col-span-3">
                    <div class="flex items-center justify-between w-full">
                        <div class="flex items-center gap-2">
                            <input type="radio" name="subject_id" value="other" id="subject_other_radio" class="sr-only peer" {{ old('subject_id') == 'other' ? 'checked' : '' }}>
                            <div class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-blue-600 peer-checked:bg-blue-50/5 pointer-events-none transition-all"></div>
                            <span class="text-sm font-semibold text-gray-700 peer-checked:text-blue-600 transition">Môn học khác</span>
                        </div>
                        <div class="w-4 h-4 rounded-full border border-gray-300 flex items-center justify-center peer-checked:border-blue-600 peer-checked:bg-blue-600 transition-all shrink-0">
                            <div class="w-1.5 h-1.5 rounded-full bg-white scale-0 peer-checked:scale-100 transition-all"></div>
                        </div>
                    </div>
                    <div class="mt-3 w-full">
                        <input type="text" id="subject_other_input" name="subject_request"
                            value="{{ old('subject_request') }}" placeholder="Nhập tên môn học khác..."
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 focus:outline-none hidden transition-all duration-300 ease-in-out">
                    </div>
                </label>
            </div>
        </div>

        {{-- NÚT NEXT --}}
        <div class="flex justify-end pt-4 border-t border-gray-100">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-semibold text-sm transition shadow-sm hover:shadow">
                Tiếp theo <i class="fas fa-arrow-right ml-1"></i>
            </button>
        </div>
    </form>

    {{-- JS: hiển thị input "Khác" khi radio được chọn --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function toggleOtherInput(radioId, inputId) {
                const radio = document.getElementById(radioId);
                const input = document.getElementById(inputId);

                if (!radio || !input) return;

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
                    const grades = item.dataset.grades.split(',');

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
                        showAllSubjects();
                    } else {
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
