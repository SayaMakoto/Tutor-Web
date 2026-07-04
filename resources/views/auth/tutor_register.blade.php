<x-alert type="success" :message="session('success')" />

@extends('layouts.auth')
@section('title', 'Đăng ký gia sư')
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
                    class="w-12 h-12 rounded-2xl bg-linear-to-br from-green-500 to-emerald-600 flex items-center justify-center shadow-lg mb-2">
                    <i class="fa-solid fa-chalkboard-teacher text-white text-xl"></i>
                </div>
                <span
                    class="text-xl font-extrabold bg-linear-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent tracking-tight">
                    GiaSu247
                </span>
            </div>

            {{-- Header --}}
            <div class="text-center mb-6">
                <h1 class="text-xl font-bold text-gray-800">Đăng ký làm Gia sư</h1>
                <p class="text-sm text-gray-500 mt-1">Chia sẻ kiến thức, tăng thu nhập của bạn</p>
            </div>

            <form method="POST" action="{{ auth()->check() ? route('become-tutor.store') : route('register.tutor.store') }}">
                @csrf

                @auth
                    {{-- Banner thông tin tài khoản hiện tại --}}
                    <div class="flex items-center gap-3 mb-5 p-3 bg-blue-50 border border-blue-200 rounded-xl">
                        <div class="w-9 h-9 rounded-full bg-blue-100 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-circle-user text-blue-500 text-lg"></i>
                        </div>
                        <div class="text-sm">
                            <p class="font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                            <p class="text-gray-500">{{ auth()->user()->email }}</p>
                        </div>
                        <span class="ml-auto text-xs font-medium bg-blue-100 text-blue-600 px-2 py-0.5 rounded-full">Học viên</span>
                    </div>
                @endauth

                @guest

                    {{-- Divider: Guest info --}}
                    <div class="flex items-center gap-3 mb-4">
                        <div class="h-px flex-1 bg-gray-200"></div>
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Thông tin cá nhân</span>
                        <div class="h-px flex-1 bg-gray-200"></div>
                    </div>

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
                    <div class="mb-4">
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

                @endguest

                {{-- Divider: Tutor info --}}
                <div class="flex items-center gap-3 mb-4 mt-2">
                    <div class="h-px flex-1 bg-gray-200"></div>
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Thông tin gia sư</span>
                    <div class="h-px flex-1 bg-gray-200"></div>
                </div>

                {{-- Học vấn --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Học vấn</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fa-solid fa-graduation-cap text-sm"></i>
                        </span>
                        <input type="text" name="education" value="{{ old('education') }}"
                            class="border border-gray-200 rounded-xl pl-10 pr-4 py-3 w-full text-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition"
                            placeholder="Cao đẳng, đại học, thạc sĩ,..." required>
                    </div>
                </div>

                {{-- Kinh nghiệm --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Số năm kinh nghiệm</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fa-solid fa-briefcase text-sm"></i>
                        </span>
                        <input type="number" name="experience" value="{{ old('experience') }}"
                            class="border border-gray-200 rounded-xl pl-10 pr-4 py-3 w-full text-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition"
                            placeholder="VD: 1, 2, 3,..." required>
                    </div>
                </div>

                {{-- Giới thiệu bản thân --}}
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fa-solid fa-id-card mr-1 text-gray-400"></i>Giới thiệu bản thân
                    </label>
                    <textarea name="bio" rows="3"
                        class="border border-gray-200 rounded-xl px-4 py-3 w-full text-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition resize-none"
                        placeholder="Mô tả ngắn về kinh nghiệm và phong cách dạy của bạn...">{{ old('bio') }}</textarea>
                </div>

                {{-- Submit --}}
                <button type="submit"
                    class="w-full bg-linear-to-r from-green-600 to-emerald-600 text-white py-3 rounded-xl font-semibold hover:shadow-lg hover:from-green-700 hover:to-emerald-700 transition-all">
                    <i class="fa-solid fa-chalkboard-teacher mr-2"></i>Đăng ký làm Gia sư
                </button>

            </form>

            {{-- Back link --}}
            <div class="text-center mt-5">
                @auth
                    <a href="{{ route('student.home') }}" class="text-xs text-gray-400 hover:text-gray-600 transition">
                        <i class="fa-solid fa-arrow-left mr-1"></i>Quay lại trang chủ
                    </a>
                @else
                    <a href="{{ route('role') }}" class="text-xs text-gray-400 hover:text-gray-600 transition">
                        <i class="fa-solid fa-arrow-left mr-1"></i>Quay lại chọn vai trò
                    </a>
                @endauth
            </div>

        </div>
    </div>
@endsection
