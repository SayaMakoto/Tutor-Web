@extends('layouts.auth')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-linear-to-br from-blue-50 to-indigo-100">

        <div class="bg-white shadow-xl rounded-2xl p-8 w-96">

            <!-- Back -->
            <div class="mb-4">
                <a href="{{ route('student.home') }}" class="text-sm text-gray-500 hover:text-blue-600 transition">
                    ← Quay lại trang chủ
                </a>
            </div>

            <!-- Title -->
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
                Đăng nhập hệ thống
            </h2>

            <form method="POST" action="{{ route('login.store') }}">
                @csrf

                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-sm text-gray-600 mb-1">
                        Email
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 transition"
                        placeholder="example@email.com">
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label class="block text-sm text-gray-600 mb-1">
                        Mật khẩu
                    </label>
                    <input type="password" name="password"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 transition"
                        placeholder="••••••••">
                </div>

                <!-- Button -->
                <button
                    class="w-full bg-blue-600 text-white py-2.5 rounded-lg hover:bg-blue-700 transition font-medium shadow-md">
                    Đăng nhập
                </button>

            </form>

            <!-- Register -->
            <p class="text-center text-sm text-gray-600 mt-6">
                Chưa có tài khoản?
                <a href="{{ route('role') }}" class="text-blue-600 hover:underline font-medium">
                    Đăng ký ngay
                </a>
            </p>

        </div>

    </div>
@endsection
