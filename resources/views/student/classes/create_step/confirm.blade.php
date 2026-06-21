@extends('student.classes.create')
@section('title', 'Bước 5: Xác nhận thông tin')
@section('step-content')
    @if (!$data)
        <div class="bg-red-50 border border-red-200 text-red-600 rounded-xl p-4 text-sm font-semibold flex items-center gap-2">
            <i class="fas fa-exclamation-circle text-base"></i>
            Không tìm thấy dữ liệu. Vui lòng tạo lại lớp.
        </div>
    @else
        <form action="{{ route('create-class.store') }}" method="POST" class="space-y-8">
            @csrf

            <div class="bg-blue-50/50 border border-blue-100 rounded-2xl p-5 mb-6">
                <div class="flex items-start gap-3">
                    <span class="text-blue-600 text-lg mt-0.5"><i class="fas fa-info-circle"></i></span>
                    <div>
                        <h4 class="text-sm font-bold text-gray-800">Kiểm tra lại thông tin lớp học</h4>
                        <p class="text-xs text-gray-500 mt-1">Vui lòng rà soát kỹ lưỡng các thông tin dưới đây trước khi gửi yêu cầu đăng lớp lên hệ thống.</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- BƯỚC 1: MÔN HỌC --}}
                <div class="bg-white border border-gray-250/70 rounded-2xl p-6 hover:shadow-sm transition-all duration-300">
                    <div class="flex items-center gap-2.5 border-b border-gray-100 pb-3 mb-4">
                        <span class="w-7 h-7 rounded-lg bg-blue-50 text-blue-500 flex items-center justify-center text-sm font-bold">
                            <i class="fas fa-book"></i>
                        </span>
                        <h3 class="text-sm font-bold text-gray-800">Thông tin môn học</h3>
                    </div>

                    <div class="space-y-3.5">
                        <div class="flex justify-between items-center gap-4">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">Ngành học</span>
                            <span class="text-sm font-semibold text-gray-800">{{ $data['grade_display'] }}</span>
                        </div>
                        <div class="flex justify-between items-center gap-4">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">Môn học</span>
                            <span class="text-sm font-semibold text-gray-800">{{ $data['subject_display'] }}</span>
                        </div>
                    </div>
                </div>

                {{-- BƯỚC 3: HÌNH THỨC & ĐỊA ĐIỂM --}}
                <div class="bg-white border border-gray-250/70 rounded-2xl p-6 hover:shadow-sm transition-all duration-300">
                    <div class="flex items-center gap-2.5 border-b border-gray-100 pb-3 mb-4">
                        <span class="w-7 h-7 rounded-lg bg-indigo-50 text-indigo-500 flex items-center justify-center text-sm font-bold">
                            <i class="fas fa-map-marked-alt"></i>
                        </span>
                        <h3 class="text-sm font-bold text-gray-800">Hình thức & Địa điểm</h3>
                    </div>

                    <div class="space-y-3.5">
                        <div class="flex justify-between items-center gap-4">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">Hình thức</span>
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold {{ $data['study_type'] === 'online' ? 'bg-blue-50 text-blue-700 border border-blue-100' : 'bg-indigo-50 text-indigo-700 border border-indigo-100' }}">
                                {{ $data['study_type'] === 'online' ? 'Trực tuyến' : 'Trực tiếp' }}
                            </span>
                        </div>
                        <div class="space-y-1">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wide block">Địa chỉ chi tiết</span>
                            <span class="text-sm font-semibold text-gray-800 block break-words">{{ $data['location'] }}</span>
                        </div>
                    </div>
                </div>

                {{-- BƯỚC 4: LỊCH HỌC --}}
                <div class="bg-white border border-gray-250/70 rounded-2xl p-6 hover:shadow-sm transition-all duration-300">
                    <div class="flex items-center gap-2.5 border-b border-gray-100 pb-3 mb-4">
                        <span class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-500 flex items-center justify-center text-sm font-bold">
                            <i class="fas fa-calendar-alt"></i>
                        </span>
                        <h3 class="text-sm font-bold text-gray-800">Thời gian & Lịch học</h3>
                    </div>

                    <div class="space-y-3.5">
                        <div class="flex justify-between items-center gap-4">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">Độ dài khóa học</span>
                            <span class="text-sm font-semibold text-gray-800">{{ $data['weeks'] }}</span>
                        </div>
                        <div class="flex justify-between items-center gap-4">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">Số ngày / tuần</span>
                            <span class="text-sm font-semibold text-gray-800">{{ $data['schedule'] }}</span>
                        </div>
                        <div class="flex justify-between items-center gap-4">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">Giờ học mỗi buổi</span>
                            <span class="text-sm font-semibold text-gray-800">{{ $data['time'] }}</span>
                        </div>
                    </div>
                </div>

                {{-- BƯỚC 2: YÊU CẦU GIA SƯ --}}
                <div class="bg-white border border-gray-250/70 rounded-2xl p-6 hover:shadow-sm transition-all duration-300 md:col-span-2">
                    <div class="flex items-center gap-2.5 border-b border-gray-100 pb-3 mb-4">
                        <span class="w-7 h-7 rounded-lg bg-purple-50 text-purple-500 flex items-center justify-center text-sm font-bold">
                            <i class="fas fa-user-tie"></i>
                        </span>
                        <h3 class="text-sm font-bold text-gray-800">Yêu cầu đối với Gia sư</h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="space-y-3.5">
                            <div class="flex justify-between items-center gap-4">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">Trình độ</span>
                                <span class="text-sm font-semibold text-gray-800">{{ $data['degree'] ?? 'Không yêu cầu' }}</span>
                            </div>
                            <div class="flex justify-between items-center gap-4">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">Kinh nghiệm</span>
                                <span class="text-sm font-semibold text-gray-800">{{ $data['experience'] ?? 'Không yêu cầu' }}</span>
                            </div>
                        </div>

                        <div class="space-y-3.5">
                            <div class="flex justify-between items-center gap-4">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">Giới tính</span>
                                <span class="text-sm font-semibold text-gray-800">{{ $data['gender_display'] ?? 'Không yêu cầu' }}</span>
                            </div>
                            <div class="flex justify-between items-center gap-4">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">Độ tuổi</span>
                                <span class="text-sm font-semibold text-gray-800">{{ $data['age_range'] ?? 'Không yêu cầu' }}</span>
                            </div>
                        </div>

                        <div class="space-y-3.5">
                            <div class="flex justify-between items-center gap-4">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">Học phí mong muốn</span>
                                <span class="text-sm font-extrabold text-blue-600">
                                    {{ $data['fee'] ? number_format($data['fee']) . ' đ/giờ' : 'Thỏa thuận' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 pt-4 mt-4 space-y-1">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wide block">Mô tả chi tiết yêu cầu</span>
                        <p class="text-sm text-gray-600 leading-relaxed italic bg-gray-50 rounded-xl p-4 border border-gray-100">{{ $data['description'] ?? 'Không có mô tả chi tiết.' }}</p>
                    </div>
                </div>

            </div>

            {{-- NÚT CHUYỂN BƯỚC --}}
            <div class="flex justify-between pt-6 border-t border-gray-100">
                <a href="{{ route('create-class.step4') }}" class="inline-flex items-center gap-2 px-6 py-3 border border-gray-200 rounded-xl font-semibold text-sm text-gray-600 hover:bg-gray-50 transition shadow-sm">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>

                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-xl font-semibold text-sm transition shadow-sm hover:shadow-md flex items-center gap-2">
                    <i class="fas fa-check-circle"></i> Xác nhận tạo lớp
                </button>
            </div>

        </form>
    @endif
@endsection
