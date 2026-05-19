@extends('student.classes.create')
@section('title', 'Bước 5: Xác nhận thông tin')
@section('step-content')
    @if (!$data)
        <div class="text-red-500">
            Không tìm thấy dữ liệu. Vui lòng tạo lại lớp.
        </div>
    @else
        <form action="{{ route('create-class.store') }}" method="POST">
            @csrf

            <div class="space-y-8">

                {{-- STEP 1 --}}
                <div class="bg-white shadow rounded-xl p-6">
                    <h2 class="text-lg font-bold mb-4 border-b pb-2">
                        📘 Thông tin môn học
                    </h2>

                    <div class="space-y-2">
                        <p><strong>Ngành học:</strong> {{ $data['grade_display'] }}</p>
                        <p><strong>Môn học:</strong> {{ $data['subject_display'] }}</p>
                    </div>
                </div>

                {{-- STEP 2 --}}
                <div class="bg-white shadow rounded-xl p-6">
                    <h2 class="text-lg font-bold mb-4 border-b pb-2">
                        👩‍🏫 Yêu cầu gia sư
                    </h2>

                    <div class="space-y-2">
                        <p><span class="font-semibold">Trình độ:</span> {{ $data['degree'] ?? 'Không yêu cầu' }}</p>
                        <p><span class="font-semibold">Kinh nghiệm:</span> {{ $data['experience'] ?? 'Không yêu cầu' }}</p>
                        <p><span class="font-semibold">Giới tính:</span> {{ $data['gender_display'] ?? 'Không yêu cầu' }}
                        </p>
                        <p><span class="font-semibold">Độ tuổi:</span> {{ $data['age_range'] ?? 'Không yêu cầu' }}</p>
                        <p><span class="font-semibold">Học phí:</span>
                            {{ $data['fee'] ? number_format($data['fee']) . ' VNĐ' : 'Thỏa thuận' }}</p>
                        <p><span class="font-semibold">Mô tả:</span> {{ $data['description'] ?? 'Không có' }}</p>
                    </div>
                </div>

                {{-- STEP 3 --}}
                <div class="bg-white shadow rounded-xl p-6">
                    <h2 class="text-lg font-bold mb-4 border-b pb-2">
                        📍 Hình thức & địa điểm
                    </h2>

                    <div class="space-y-2">
                        <p>
                            <span class="font-semibold">Hình thức:</span>
                            {{ $data['study_type'] === 'online' ? 'Online' : 'Offline' }}
                        </p>

                        <p>
                            <span class="font-semibold">Địa điểm:</span>
                            {{ $data['location'] }}
                        </p>
                    </div>
                </div>

                {{-- STEP 4 --}}
                <div class="bg-white shadow rounded-xl p-6">
                    <h2 class="text-lg font-bold mb-4 border-b pb-2">
                        🗓 Lịch học
                    </h2>

                    <div class="space-y-2">
                        <p><span class="font-semibold">Số tuần:</span> {{ $data['weeks'] }}</p>
                        <p><span class="font-semibold">Ngày học:</span> {{ $data['schedule'] }}</p>
                        <p><span class="font-semibold">Khung giờ:</span> {{ $data['time'] }}</p>
                    </div>
                </div>

            </div>

            {{-- BUTTON --}}
            <div class="flex justify-between mt-10">
                <a href="{{ route('create-class.step4') }}" class="px-6 py-2 border rounded-lg hover:bg-gray-100">
                    ← Quay lại
                </a>

                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg">
                    ✅ Xác nhận tạo lớp
                </button>
            </div>

        </form>
    @endif
@endsection
