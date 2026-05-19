<x-alert type="success" :message="session('success')" />

@extends('layouts.auth')
@section('title', 'Đăng ký gia sư')
@section('content')
    <div class="min-h-screen flex items-center justify-center bg-linear-to-br from-blue-100 to-blue-200">

        <div class="bg-white shadow-2xl rounded-2xl p-8 w-full max-w-md">
            <div class="mb-4">
                <a href="{{ route('student.home') }}" class="text-sm text-gray-500 hover:text-blue-600 transition">
                    ← Quay lại trang chủ
                </a>
            </div>
            <h2 class="text-2xl font-bold text-center mb-6 text-gray-700">
                Đăng ký Gia sư
            </h2>

            <form method="POST" action="{{ route('register.tutor.store') }}">
                @csrf

                @guest

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-600 mb-1">
                            Họ và tên
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400"
                            placeholder="Nhập họ tên" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-600 mb-1">
                            Giới tính
                        </label>
                        <div class="flex items-center space-x-4">
                            <label class="flex items-center">
                                <input type="radio" name="gender" value="male"
                                    {{ old('gender') === 'male' ? 'checked' : '' }} class="form-radio text-blue-600">
                                <span class="ml-2">Nam</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="gender" value="female"
                                    {{ old('gender') === 'female' ? 'checked' : '' }} class="form-radio text-blue-600">
                                <span class="ml-2">Nữ</span>
                            </label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-600 mb-1">
                            Email
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400" placeholder="Nhập email"
                            required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-600 mb-1">
                            Mật khẩu
                        </label>
                        <input type="password" name="password"
                            class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400"
                            placeholder="Nhập mật khẩu" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-600 mb-1">
                            Xác nhận mật khẩu
                        </label>
                        <input type="password" name="password_confirmation"
                            class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400"
                            placeholder="Nhập lại mật khẩu" required>
                    </div>

                @endguest


                {{-- Phần chung cho tutor --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-600 mb-1">
                        Học vấn
                    </label>
                    <input type="text" name="education" value="{{ old('education') }}"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400"
                        placeholder="Cao đẳng, đại học, thạc sĩ,..." required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-600 mb-1">
                        Số năm kinh nghiệm
                    </label>
                    <input type="number" name="experience" value="{{ old('experience') }}"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400"
                        placeholder="VD: 1, 2, 3,..." required>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-600 mb-1">
                        Giới thiệu bản thân
                    </label>
                    <textarea name="bio" rows="3" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400">{{ old('bio') }}</textarea>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                    Đăng ký làm Gia sư
                </button>

            </form>

        </div>

    </div>
@endsection
