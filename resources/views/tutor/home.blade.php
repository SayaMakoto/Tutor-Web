@extends('layouts.tutor')
@section('title', 'Trang chủ gia sư')
@section('content')

    {{-- 1️⃣ SLIDER DÀNH CHO GIA SƯ --}}
    <x-partials.slider />

    {{-- 2️⃣ GIỚI THIỆU NGẮN GỌN DÀNH CHO GIA SƯ --}}
    <div class="bg-white p-10 rounded-2xl shadow mb-10 text-center">
        <h2 class="text-3xl font-bold mb-4">
            Hàng trăm lớp học đang chờ bạn
        </h2>
        <p class="text-gray-600 max-w-2xl mx-auto">
            Chọn lớp phù hợp chuyên môn, khu vực và mức học phí mong muốn.
            Ứng tuyển nhanh chóng chỉ trong vài bước.
        </p>
    </div>

    {{-- 3️⃣ LỚP ĐÃ DUYỆT (approved) --}}
    <div class="mb-12">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">
                Lớp đang tuyển gia sư
            </h2>

            <a href="#" class="text-blue-600 font-semibold">
                Xem tất cả →
            </a>
        </div>

        @if ($approvedClasses->count())
            <div class="grid md:grid-cols-3 gap-6">
                @foreach ($approvedClasses as $class)
                    <x-partials.class-card :classRequest="$class" />
                @endforeach
            </div>
        @else
            <p class="text-gray-500">
                Hiện chưa có lớp nào đang tuyển.
            </p>
        @endif
    </div>

    {{-- 4️⃣ THAY HỌC PHÍ THAM KHẢO → THU NHẬP TIỀM NĂNG --}}
    <div class="bg-linear-to-br from-blue-50 to-indigo-50 p-10 rounded-2xl mb-12">
        <h2 class="text-2xl font-bold mb-8 text-center">
            Thu nhập tiềm năng của gia sư
        </h2>

        <div class="grid md:grid-cols-3 gap-6 text-center">

            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="font-semibold text-lg mb-2">Dạy 2 lớp</h3>
                <p class="text-blue-600 text-xl font-bold">
                    3 – 6 triệu / tháng
                </p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="font-semibold text-lg mb-2">Dạy 4 lớp</h3>
                <p class="text-blue-600 text-xl font-bold">
                    6 – 12 triệu / tháng
                </p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="font-semibold text-lg mb-2">Full-time</h3>
                <p class="text-blue-600 text-xl font-bold">
                    15+ triệu / tháng
                </p>
            </div>

        </div>
    </div>

    {{-- 5️⃣ CÁCH NHẬN LỚP --}}
    <div class="bg-white p-10 rounded-2xl shadow mb-12 text-center">
        <h2 class="text-2xl font-bold mb-8">
            Nhận lớp chỉ với 3 bước
        </h2>

        <div class="grid md:grid-cols-3 gap-8">
            <div>
                <div class="text-blue-600 text-4xl mb-3">1</div>
                <h3 class="font-semibold mb-2">Xem lớp phù hợp</h3>
                <p class="text-gray-600 text-sm">
                    Lọc theo môn học, khu vực và mức học phí.
                </p>
            </div>

            <div>
                <div class="text-blue-600 text-4xl mb-3">2</div>
                <h3 class="font-semibold mb-2">Ứng tuyển</h3>
                <p class="text-gray-600 text-sm">
                    Gửi thông tin và mức phí mong muốn.
                </p>
            </div>

            <div>
                <div class="text-blue-600 text-4xl mb-3">3</div>
                <h3 class="font-semibold mb-2">Bắt đầu dạy</h3>
                <p class="text-gray-600 text-sm">
                    Liên hệ học viên và bắt đầu giảng dạy.
                </p>
            </div>
        </div>
    </div>

    {{-- 7️⃣ CTA --}}
    <div class="bg-blue-600 text-white p-10 rounded-2xl text-center">
        <h2 class="text-3xl font-bold mb-4">
            Sẵn sàng nhận lớp hôm nay?
        </h2>
        <p class="mb-6 text-blue-100">
            Cập nhật hồ sơ của bạn để tăng cơ hội được chọn.
        </p>
        <a href="#" class="bg-yellow-400 text-black px-6 py-3 rounded-xl font-semibold">
            Cập nhật hồ sơ
        </a>
    </div>

@endsection
