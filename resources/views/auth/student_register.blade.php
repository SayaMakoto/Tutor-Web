<x-alert type="success" :message="session('success')" />

@extends('layouts.auth')
@section('title', 'Đăng ký học viên')
@section('content')
    <div
        class="min-h-screen flex items-center justify-center bg-linear-to-br from-blue-600 via-indigo-600 to-purple-700 relative overflow-hidden px-4 py-10">

        {{-- Decorative circles --}}
        <div class="absolute -top-20 -left-20 w-64 h-64 bg-white/10 rounded-full pointer-events-none"></div>
        <div class="absolute -bottom-25 -right-15 w-80 h-80 bg-white/10 rounded-full pointer-events-none"></div>

        <div class="relative z-10 bg-white rounded-2xl shadow-2xl p-8 w-full max-w-lg">

            {{-- Logo --}}
            <div class="flex flex-col items-center mb-5">
                <div
                    class="w-12 h-12 rounded-2xl bg-linear-to-br from-blue-600 to-indigo-600 flex items-center justify-center shadow-lg mb-2">
                    <i class="fa-solid fa-graduation-cap text-white text-xl"></i>
                </div>
                <span
                    class="text-xl font-extrabold bg-linear-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent tracking-tight">
                    GiaSu247
                </span>
            </div>

            {{-- Header --}}
            <div class="text-center mb-2">
                <h1 class="text-xl font-bold text-gray-800">Tạo tài khoản học viên</h1>
                <p class="text-sm text-gray-500 mt-1">Bắt đầu hành trình học tập của bạn</p>
            </div>

            <form method="POST" action="{{ route('register.student.store') }}">
                @csrf

                {{-- Họ tên --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Họ và tên</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fa-solid fa-user text-sm"></i>
                        </span>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="border border-gray-200 rounded-xl pl-10 pr-4 py-3 w-full text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition"
                            placeholder="Nhập họ tên" required>
                    </div>
                </div>

                {{-- Giới tính --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Giới tính</label>
                    <div class="flex gap-3">
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="gender" value="male"
                                {{ old('gender') === 'male' ? 'checked' : '' }} class="sr-only peer">
                            <div
                                class="peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600 border-2 border-gray-200 rounded-xl py-2.5 text-center text-sm font-medium text-gray-600 transition-all hover:border-blue-300">
                                <i class="fa-solid fa-mars mr-1"></i>Nam
                            </div>
                        </label>
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="gender" value="female"
                                {{ old('gender') === 'female' ? 'checked' : '' }} class="sr-only peer">
                            <div
                                class="peer-checked:bg-pink-500 peer-checked:text-white peer-checked:border-pink-500 border-2 border-gray-200 rounded-xl py-2.5 text-center text-sm font-medium text-gray-600 transition-all hover:border-pink-300">
                                <i class="fa-solid fa-venus mr-1"></i>Nữ
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Email --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fa-solid fa-envelope text-sm"></i>
                        </span>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="border border-gray-200 rounded-xl pl-10 pr-4 py-3 w-full text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition"
                            placeholder="Nhập email" required>
                    </div>
                </div>

                {{-- Mật khẩu --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fa-solid fa-lock text-sm"></i>
                        </span>
                        <input type="password" name="password"
                            class="border border-gray-200 rounded-xl pl-10 pr-4 py-3 w-full text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition"
                            placeholder="Nhập mật khẩu" required>
                    </div>
                </div>

                {{-- Xác nhận mật khẩu --}}
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Xác nhận mật khẩu</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fa-solid fa-lock text-sm"></i>
                        </span>
                        <input type="password" name="password_confirmation"
                            class="border border-gray-200 rounded-xl pl-10 pr-4 py-3 w-full text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition"
                            placeholder="Nhập lại mật khẩu" required>
                    </div>
                </div>

                {{-- Submit --}}
                <button type="submit"
                    class="w-full bg-linear-to-r from-blue-600 to-indigo-600 text-white py-3 rounded-xl font-semibold hover:shadow-lg hover:from-blue-700 hover:to-indigo-700 transition-all">
                    <i class="fa-solid fa-user-plus mr-2"></i>Tạo tài khoản
                </button>

            </form>

            {{-- Login link --}}
            <p class="text-center text-sm text-gray-500 mt-5">
                Đã có tài khoản?
                <a href="{{ route('login') }}"
                    class="text-blue-600 hover:text-indigo-600 font-semibold hover:underline transition">
                    Đăng nhập
                </a>
            </p>

            {{-- Back link --}}
            <div class="text-center mt-2">
                <a href="{{ route('role') }}" class="text-xs text-gray-400 hover:text-gray-600 transition">
                    <i class="fa-solid fa-arrow-left mr-1"></i>Quay lại chọn vai trò
                </a>
            </div>

        </div>
    </div>
@endsection
