@extends('layouts.auth')

@section('content')
    {{-- Full-page gradient background with decorative circles --}}
    <div
        class="min-h-screen flex items-center justify-center bg-linear-to-br from-blue-600 via-indigo-600 to-purple-700 relative overflow-hidden px-4">

        {{-- Decorative background circles --}}
        <div class="absolute -top-20 -left-20 w-64 h-64 bg-white/10 rounded-full pointer-events-none"></div>
        <div class="absolute -bottom-25 -right-15 w-80 h-80 bg-white/10 rounded-full pointer-events-none"></div>
        <div class="absolute top-1/2 -left-30 w-48 h-48 bg-white/5 rounded-full pointer-events-none"></div>

        {{-- Card --}}
        <div class="relative z-10 bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md">

            {{-- Logo --}}
            <div class="flex flex-col items-center mb-6">
                <div
                    class="w-14 h-14 rounded-2xl bg-linear-to-br from-blue-600 to-indigo-600 flex items-center justify-center shadow-lg mb-3">
                    <i class="fa-solid fa-graduation-cap text-white text-2xl"></i>
                </div>
                <span
                    class="text-2xl font-extrabold bg-linear-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent tracking-tight">
                    GiaSu247
                </span>
            </div>

            {{-- Title --}}
            <div class="text-center mb-7">
                <h1 class="text-2xl font-bold text-gray-800">Chào mừng trở lại!</h1>
                <p class="text-sm text-gray-500 mt-1">Đăng nhập để tiếp tục</p>
            </div>

            <form method="POST" action="{{ route('login.store') }}">
                @csrf

                {{-- Email --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fa-solid fa-envelope text-sm"></i>
                        </span>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="border border-gray-200 rounded-xl pl-10 pr-4 py-3 w-full text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition"
                            placeholder="example@email.com">
                    </div>
                </div>

                {{-- Password --}}
                <div class="mb-5" x-data="{ show: false }">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fa-solid fa-lock text-sm"></i>
                        </span>
                        <input :type="show ? 'text' : 'password'" name="password"
                            class="border border-gray-200 rounded-xl pl-10 pr-12 py-3 w-full text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition"
                            placeholder="••••••••">
                        <button type="button" @click="show = !show"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-blue-500 transition">
                            <i :class="show ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'" class="text-sm"></i>
                        </button>
                    </div>
                </div>

                {{-- Remember me --}}
                <div class="flex items-center mb-6">
                    <label class="flex items-center gap-2 cursor-pointer select-none group">
                        <input type="checkbox" name="remember"
                            class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-400 cursor-pointer">
                        <span class="text-sm text-gray-600 group-hover:text-gray-800 transition">Ghi nhớ đăng nhập</span>
                    </label>
                </div>

                {{-- Submit --}}
                <button type="submit"
                    class="w-full bg-linear-to-r from-blue-600 to-indigo-600 text-white py-3 rounded-xl font-semibold hover:shadow-lg hover:from-blue-700 hover:to-indigo-700 transition-all">
                    <i class="fa-solid fa-right-to-bracket mr-2"></i>Đăng nhập
                </button>
            </form>

            {{-- Register link --}}
            <p class="text-center text-sm text-gray-500 mt-6">
                Chưa có tài khoản?
                <a href="{{ route('role') }}"
                    class="text-blue-600 hover:text-indigo-600 font-semibold hover:underline transition">
                    Đăng ký ngay
                </a>
            </p>

            {{-- Back link --}}
            <div class="text-center mt-3">
                <a href="{{ route('student.home') }}" class="text-xs text-gray-400 hover:text-gray-600 transition">
                    <i class="fa-solid fa-arrow-left mr-1"></i>Quay lại trang chủ
                </a>
            </div>

        </div>
    </div>
@endsection
