@extends('layouts.tutor')

@section('title', 'Trang chủ gia sư')

@section('content')
    @auth
        @if (is_null(auth()->user()->phone) || is_null(auth()->user()->date_of_birth))
            <div
                class="mb-6 p-4 bg-linear-to-r from-red-50 to-orange-50 border border-red-100 rounded-2xl flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center text-red-600">
                        <i class="fas fa-exclamation-triangle text-lg"></i>
                    </div>
                    <div class="text-left">
                        <h4 class="font-bold text-gray-800 text-sm">Hồ sơ chưa hoàn thiện!</h4>
                        <p class="text-xs text-gray-500 mt-0.5">Vui lòng cập nhật Số điện thoại và Ngày sinh để tài khoản hoạt
                            động bình thường.</p>
                    </div>
                </div>
                <a href="{{ route('profile.edit') }}"
                    class="bg-red-600 hover:bg-red-700 text-white text-xs font-bold px-4 py-2 rounded-xl transition shadow-sm whitespace-nowrap">
                    Cập nhật ngay
                </a>
            </div>
        @endif
    @endauth

    {{-- Hero Banner --}}
    <x-partials.slider />

    {{-- Giới thiệu --}}
    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 mb-8">

        <div class="text-center mb-6">

            <h2 class="text-2xl font-bold text-gray-800 mb-2">
                Hàng trăm lớp học đang chờ bạn
            </h2>

            <p class="text-gray-500 max-w-2xl mx-auto text-sm leading-relaxed">

                Chọn lớp phù hợp chuyên môn, khu vực và mức học phí mong muốn.
                Ứng tuyển nhanh chóng chỉ trong vài bước.

            </p>

        </div>

        <div class="grid grid-cols-3 gap-4 max-w-lg mx-auto text-center">

            <div class="flex flex-col items-center gap-1 p-3 rounded-xl bg-green-50">

                <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">

                    <i class="fas fa-book-open text-green-600 text-lg"></i>

                </div>

                <p class="text-xl font-bold text-green-600">
                    {{ $approvedClasses->count() }}+
                </p>

                <p class="text-xs text-gray-500">
                    Lớp mới
                </p>

            </div>

            <div class="flex flex-col items-center gap-1 p-3 rounded-xl bg-emerald-50">

                <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center">

                    <i class="fas fa-users text-emerald-600 text-lg"></i>

                </div>

                <p class="text-xl font-bold text-emerald-600">

                    500+

                </p>

                <p class="text-xs text-gray-500">

                    Gia sư

                </p>

            </div>

            <div class="flex flex-col items-center gap-1 p-3 rounded-xl bg-lime-50">

                <div class="w-10 h-10 bg-lime-100 rounded-xl flex items-center justify-center">

                    <i class="fas fa-star text-lime-600 text-lg"></i>

                </div>

                <p class="text-xl font-bold text-lime-600">

                    4.9

                </p>

                <p class="text-xs text-gray-500">

                    Đánh giá

                </p>

            </div>

        </div>

    </div>


    {{-- Lớp đang tuyển --}}
    <div class="mb-8">

        <div class="flex justify-between items-center mb-5">

            <div>

                <h2 class="text-xl font-bold text-gray-800">

                    Lớp đang tuyển gia sư

                </h2>

                <p class="text-sm text-gray-500 mt-0.5">

                    Các lớp học mới được duyệt

                </p>

            </div>

            <a href="{{ route('tutor.classes.index') }}"
                class="text-sm font-semibold text-green-600
                       hover:text-emerald-600 transition
                       flex items-center gap-1">

                Xem tất cả

                <i class="fas fa-arrow-right text-xs"></i>

            </a>

        </div>


        @if ($approvedClasses->count())

            <div class="grid md:grid-cols-3 gap-5">

                @foreach ($approvedClasses as $class)
                    <<<<<<< HEAD <x-partials.class-card :classRequest="$class" />
                    =======
                    <x-partials.class-card :classRequest="$class" :showCancel="false" detailRoute="tutor.classes.show" />
                    >>>>>>> 3ac214b (feat: update tutor onboarding documents and enhance profile edit UI)
                @endforeach

            </div>
        @else
            <div class="text-center py-14 bg-white rounded-2xl border border-dashed border-gray-200">

                <i class="fas fa-book-open text-gray-300 text-4xl mb-3"></i>

                <p class="text-gray-500 font-medium">

                    Hiện chưa có lớp nào đang tuyển

                </p>

                <p class="text-gray-400 text-sm mt-1">

                    Hãy quay lại sau nhé!

                </p>

            </div>

        @endif

    </div>


    {{-- Thu nhập tiềm năng --}}
    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 mb-8">

        <div class="text-center mb-6">

            <h2 class="text-xl font-bold text-gray-800">

                Thu nhập tiềm năng

            </h2>

            <p class="text-sm text-gray-500 mt-1">

                Thu nhập trung bình theo số lượng lớp

            </p>

        </div>

        <div class="grid md:grid-cols-3 gap-4 text-center">

            <div class="p-5 rounded-xl border border-green-100 bg-green-50 hover:shadow-md transition">

                <div
                    class="w-10 h-10 bg-green-100 rounded-xl
                            flex items-center justify-center
                            mx-auto mb-3">

                    <i class="fas fa-wallet text-green-600"></i>

                </div>

                <h3 class="font-semibold text-gray-700 mb-1">

                    Dạy 2 lớp

                </h3>

                <p class="text-green-600 text-lg font-bold">

                    3 – 6 triệu

                </p>

                <p class="text-xs text-gray-400 mt-0.5">

                    / tháng

                </p>

            </div>


            <div class="p-5 rounded-xl border border-emerald-100 bg-emerald-50 hover:shadow-md transition">

                <div
                    class="w-10 h-10 bg-emerald-100 rounded-xl
                            flex items-center justify-center
                            mx-auto mb-3">

                    <i class="fas fa-coins text-emerald-600"></i>

                </div>

                <h3 class="font-semibold text-gray-700 mb-1">

                    Dạy 4 lớp

                </h3>

                <p class="text-emerald-600 text-lg font-bold">

                    6 – 12 triệu

                </p>

                <p class="text-xs text-gray-400 mt-0.5">

                    / tháng

                </p>

            </div>


            <div class="p-5 rounded-xl border border-teal-100 bg-teal-50 hover:shadow-md transition">

                <div
                    class="w-10 h-10 bg-teal-100 rounded-xl
                            flex items-center justify-center
                            mx-auto mb-3">

                    <i class="fas fa-trophy text-teal-600"></i>

                </div>

                <h3 class="font-semibold text-gray-700 mb-1">

                    Full-time

                </h3>

                <p class="text-teal-600 text-lg font-bold">

                    15+ triệu

                </p>

                <p class="text-xs text-gray-400 mt-0.5">

                    / tháng

                </p>

            </div>

        </div>

    </div>


    {{-- Nhận lớp --}}
    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 mb-8">

        <div class="text-center mb-8">

            <h2 class="text-xl font-bold text-gray-800">

                Nhận lớp chỉ với 3 bước

            </h2>

        </div>

        <div class="grid md:grid-cols-3 gap-8 text-center">

            <div>

                <div
                    class="w-14 h-14 rounded-2xl bg-green-100
                            flex items-center justify-center
                            mx-auto mb-4">

                    <i class="fas fa-search text-green-600 text-xl"></i>

                </div>

                <h3 class="font-semibold mb-2">

                    Xem lớp phù hợp

                </h3>

                <p class="text-gray-500 text-sm">

                    Lọc theo môn học, khu vực và mức học phí.

                </p>

            </div>


            <div>

                <div
                    class="w-14 h-14 rounded-2xl bg-emerald-100
                            flex items-center justify-center
                            mx-auto mb-4">

                    <i class="fas fa-paper-plane text-emerald-600 text-xl"></i>

                </div>

                <h3 class="font-semibold mb-2">

                    Ứng tuyển

                </h3>

                <p class="text-gray-500 text-sm">

                    Gửi thông tin và mức phí mong muốn.

                </p>

            </div>


            <div>

                <div
                    class="w-14 h-14 rounded-2xl bg-teal-100
                            flex items-center justify-center
                            mx-auto mb-4">

                    <i class="fas fa-chalkboard-teacher text-teal-600 text-xl"></i>

                </div>

                <h3 class="font-semibold mb-2">

                    Bắt đầu dạy

                </h3>

                <p class="text-gray-500 text-sm">

                    Liên hệ học viên và bắt đầu giảng dạy.

                </p>

            </div>

        </div>

    </div>


    {{-- CTA --}}
    <div
        class="relative bg-gradient-to-br
               from-green-600 via-emerald-600 to-teal-700
               text-white p-10 rounded-2xl text-center overflow-hidden">

        <div
            class="absolute top-0 right-0
                   w-40 h-40 bg-white/5 rounded-full
                   -translate-y-1/2 translate-x-1/2">

        </div>

        <h2 class="text-2xl font-bold mb-2 relative z-10">

            Sẵn sàng nhận lớp hôm nay?

        </h2>

        <p class="mb-6 text-green-100 text-sm relative z-10">

            Cập nhật hồ sơ để tăng cơ hội được học viên lựa chọn.

        </p>

        <a href="{{ route('tutor.profile.edit') }}"
            class="relative z-10 inline-flex items-center gap-2

                   bg-yellow-400 text-gray-900

                   px-7 py-3 rounded-xl font-bold

                   hover:bg-yellow-300

                   transition shadow-lg">

            <i class="fas fa-user-pen"></i>

            Cập nhật hồ sơ

        </a>

    </div>

@endsection
