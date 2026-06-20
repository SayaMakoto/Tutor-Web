@extends('layouts.auth')
@section('title', 'Chọn vai trò')
@section('content')
    <div
        class="min-h-screen flex items-center justify-center bg-linear-to-br from-purple-700 via-indigo-600 to-blue-600 relative overflow-hidden px-4 py-10">

        {{-- Decorative circles --}}
        <div class="absolute -top-15 -right-15 w-64 h-64 bg-white/10 rounded-full pointer-events-none"></div>
        <div class="absolute -bottom-20 -left-20 w-80 h-80 bg-white/10 rounded-full pointer-events-none"></div>

        <div class="relative z-10 bg-white rounded-2xl shadow-2xl p-10 w-full max-w-2xl">

            {{-- Header --}}
            <div class="text-center mb-8">
                <div
                    class="w-14 h-14 rounded-2xl bg-linear-to-br from-blue-600 to-indigo-600 flex items-center justify-center shadow-lg mx-auto mb-3">
                    <i class="fa-solid fa-graduation-cap text-white text-2xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-800">Bạn muốn đăng ký với vai trò gì?</h1>
                <p class="text-sm text-gray-500 mt-1">Chọn một trong hai vai trò bên dưới để tiếp tục</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                {{-- Học viên --}}
                <a href="{{ route('register.student') }}"
                    class="group border-2 border-blue-200 hover:border-blue-500 hover:bg-blue-50 rounded-2xl p-6 text-center transition-all duration-200 hover:scale-105 hover:shadow-lg block">

                    <div
                        class="w-16 h-16 rounded-full bg-blue-100 group-hover:bg-blue-200 flex items-center justify-center mx-auto mb-4 transition">
                        <i class="fa-solid fa-user-graduate text-blue-600 text-2xl"></i>
                    </div>

                    <p class="text-lg font-bold text-gray-800 mb-3">Học viên</p>

                    <ul class="text-sm text-gray-500 space-y-1 text-left">
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-check text-blue-500 text-xs"></i>
                            Tìm gia sư phù hợp dễ dàng
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-check text-blue-500 text-xs"></i>
                            Đặt lịch học linh hoạt
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-check text-blue-500 text-xs"></i>
                            Theo dõi tiến độ học tập
                        </li>
                    </ul>
                </a>

                {{-- Gia sư --}}
                <a href="{{ route('register.tutor') }}"
                    class="group border-2 border-emerald-200 hover:border-emerald-500 hover:bg-emerald-50 rounded-2xl p-6 text-center transition-all duration-200 hover:scale-105 hover:shadow-lg block">

                    <div
                        class="w-16 h-16 rounded-full bg-emerald-100 group-hover:bg-emerald-200 flex items-center justify-center mx-auto mb-4 transition">
                        <i class="fa-solid fa-chalkboard-teacher text-emerald-600 text-2xl"></i>
                    </div>

                    <p class="text-lg font-bold text-gray-800 mb-3">Gia sư</p>

                    <ul class="text-sm text-gray-500 space-y-1 text-left">
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-check text-emerald-500 text-xs"></i>
                            Đăng hồ sơ & tiếp nhận học viên
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-check text-emerald-500 text-xs"></i>
                            Quản lý lịch dạy chủ động
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-check text-emerald-500 text-xs"></i>
                            Tăng thu nhập từ việc dạy
                        </li>
                    </ul>
                </a>

            </div>

            {{-- Back --}}
            <div class="text-center mt-8">
                <a href="{{ route('student.home') }}" class="text-sm text-gray-400 hover:text-gray-600 transition">
                    <i class="fa-solid fa-arrow-left mr-1"></i>Quay lại trang chủ
                </a>
            </div>

        </div>
    </div>
@endsection
