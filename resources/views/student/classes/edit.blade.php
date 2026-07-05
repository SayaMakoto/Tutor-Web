@extends($layout)
@section('title', 'Chỉnh sửa yêu cầu tạo lớp')

@section('content')
<div class="min-h-screen bg-gray-50/50 py-10">
    <div class="max-w-4xl mx-auto bg-white shadow-sm border border-gray-100 rounded-2xl p-6 md:p-10">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Chỉnh sửa yêu cầu tạo lớp #{{ $class_request->id }}</h1>

        @if(session('error'))
            <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-6 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('classes.update', $class_request->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Subject -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Môn học <span class="text-red-500">*</span></label>
                    <select name="subject_id" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none" required>
                        <option value="">Chọn môn học</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ old('subject_id', $class_request->subject_id) == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('subject_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Grade -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Lớp / Cấp học <span class="text-red-500">*</span></label>
                    <select name="grade_id" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none" required>
                        <option value="">Chọn lớp / cấp học</option>
                        @foreach($grades as $grade)
                            <option value="{{ $grade->id }}" {{ old('grade_id', $class_request->grade_id) == $grade->id ? 'selected' : '' }}>
                                {{ $grade->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('grade_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Degree -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Yêu cầu trình độ</label>
                    <select name="degree" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none">
                        <option value="Không yêu cầu" {{ old('degree', $class_request->degree) == 'Không yêu cầu' ? 'selected' : '' }}>Không yêu cầu</option>
                        <option value="Cao đẳng" {{ old('degree', $class_request->degree) == 'Cao đẳng' ? 'selected' : '' }}>Cao đẳng</option>
                        <option value="Đại học" {{ old('degree', $class_request->degree) == 'Đại học' ? 'selected' : '' }}>Đại học</option>
                        <option value="Nghề" {{ old('degree', $class_request->degree) == 'Nghề' ? 'selected' : '' }}>Nghề</option>
                    </select>
                    @error('degree') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Experience -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kinh nghiệm</label>
                    <select name="experience" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none">
                        <option value="Không yêu cầu" {{ old('experience', $class_request->experience) == 'Không yêu cầu' ? 'selected' : '' }}>Không yêu cầu</option>
                        <option value="Sinh viên dạy kèm" {{ old('experience', $class_request->experience) == 'Sinh viên dạy kèm' ? 'selected' : '' }}>Sinh viên dạy kèm</option>
                        <option value="Giáo viên" {{ old('experience', $class_request->experience) == 'Giáo viên' ? 'selected' : '' }}>Giáo viên</option>
                    </select>
                    @error('experience') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Gender -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Giới tính gia sư</label>
                    <select name="gender" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none">
                        <option value="no_need" {{ old('gender', $class_request->gender) == 'no_need' ? 'selected' : '' }}>Không yêu cầu</option>
                        <option value="male" {{ old('gender', $class_request->gender) == 'male' ? 'selected' : '' }}>Nam</option>
                        <option value="female" {{ old('gender', $class_request->gender) == 'female' ? 'selected' : '' }}>Nữ</option>
                    </select>
                    @error('gender') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Age Range -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Độ tuổi</label>
                    <select name="age_range" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none">
                        <option value="Không yêu cầu" {{ old('age_range', $class_request->age_range) == 'Không yêu cầu' ? 'selected' : '' }}>Không yêu cầu</option>
                        <option value="18-25" {{ old('age_range', $class_request->age_range) == '18-25' ? 'selected' : '' }}>18 - 25</option>
                        <option value="26-35" {{ old('age_range', $class_request->age_range) == '26-35' ? 'selected' : '' }}>26 - 35</option>
                    </select>
                    @error('age_range') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Study Type -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Hình thức học <span class="text-red-500">*</span></label>
                    <select name="study_type" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none" required>
                        <option value="online" {{ old('study_type', $class_request->study_type) == 'online' ? 'selected' : '' }}>Trực tuyến (Online)</option>
                        <option value="offline" {{ old('study_type', $class_request->study_type) == 'offline' ? 'selected' : '' }}>Tại nhà (Offline)</option>
                    </select>
                    @error('study_type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Location -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Địa điểm học</label>
                    <input type="text" name="location" value="{{ old('location', $class_request->location) }}" placeholder="Nhập địa chỉ nếu học Offline" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none">
                    @error('location') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Fee -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Học phí (VNĐ/buổi) <span class="text-red-500">*</span></label>
                    <input type="number" name="fee" value="{{ old('fee', $class_request->fee) }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none" required>
                    @error('fee') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Weeks -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Thời gian đào tạo mong muốn <span class="text-red-500">*</span></label>

                    <input type="hidden" name="weeks" id="weeks_hidden" value="{{ old('weeks', $class_request->weeks ?? '1 tuần') }}">

                    <div class="flex items-center gap-3">
                        {{-- Ô nhập số --}}
                        <div class="relative flex-1">
                            <input type="number" id="weeks_val" min="1" max="100" value="1"
                                class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none font-semibold">
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
                    <p class="text-xs text-gray-400 mt-2">Tổng thời gian: <span id="weeks_summary" class="font-bold text-blue-600">1 tuần</span></p>
                </div>
            </div>

            <!-- Description -->
            <div class="mb-8">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Mô tả thêm</label>
                <textarea name="description" rows="4" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none">{{ old('description', $class_request->description) }}</textarea>
                @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="flex gap-4">
                <a href="{{ route('classes.show', $class_request->id) }}" class="px-6 py-3 rounded-xl font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 transition-colors">
                    Hủy bỏ
                </a>
                <button type="submit" class="px-6 py-3 rounded-xl font-semibold text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                    Lưu thay đổi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const weeksHidden = document.getElementById('weeks_hidden');
        const weeksVal = document.getElementById('weeks_val');
        const btnUnitWeek = document.getElementById('btn_unit_week');
        const btnUnitMonth = document.getElementById('btn_unit_month');
        const weeksSummary = document.getElementById('weeks_summary');

        let currentUnit = 'tuần';

        const initVal = weeksHidden.value ? weeksHidden.value.trim() : '1 tuần';
        const match = initVal.match(/^(\d+)\s*(tuần|tháng)$/i);
        
        if (match) {
            weeksVal.value = parseInt(match[1]);
            currentUnit = match[2].toLowerCase();
        } else {
            weeksVal.value = 1;
            currentUnit = 'tuần';
        }

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

        function syncValue() {
            const num = weeksVal.value || 1;
            const result = `${num} ${currentUnit}`;
            weeksHidden.value = result;
            weeksSummary.textContent = result;
        }

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

        updateUnitUI();
    });
</script>
@endpush
