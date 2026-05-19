@extends('layouts.auth')

@section('title', 'Admin Login')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-linear-to-br from-gray-900 to-gray-800">

        <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8">

            {{-- Header --}}
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800">
                    Admin Login
                </h1>
                <p class="text-gray-500 text-sm mt-2">
                    Khu vực quản trị hệ thống
                </p>
            </div>

            {{-- Form --}}
            <form action="{{ route('admin.login') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-semibold mb-2 text-gray-700">
                        Email
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        placeholder="admin@example.com">
                </div>

                {{-- Password --}}
                <div>
                    <label class="block text-sm font-semibold mb-2 text-gray-700">
                        Mật khẩu
                    </label>
                    <input type="password" name="password"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        placeholder="••••••••">

                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Button --}}
                <button type="submit"
                    class="w-full bg-gray-900 text-white py-2 rounded-lg hover:bg-black transition font-semibold">
                    Đăng nhập
                </button>
            </form>

            {{-- Back to home --}}
            <div class="text-center mt-6">
                <a href="{{ route('student.home') }}" class="text-sm text-gray-500 hover:text-gray-700">
                    ← Quay lại trang chủ
                </a>
            </div>

        </div>
    </div>
@endsection
