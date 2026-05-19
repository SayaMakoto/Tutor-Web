@extends('layouts.auth')
@section('title', 'Chọn vai trò')
@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-100">

        <div class="bg-white shadow-xl rounded-2xl p-8 w-full max-w-2xl">

            <h2 class="text-2xl font-bold text-center mb-8 text-gray-800">
                Bạn đăng ký với vai trò gì?
            </h2>

            <div class="grid grid-cols-2 gap-8">

                <!-- Học viên -->
                <a href="{{ route('register.student') }}"
                    class="border rounded-xl p-6 text-center hover:shadow-xl hover:border-blue-500 transition group">

                    <x-heroicon-o-user class="w-16 h-16 mx-auto mb-4 text-blue-500 group-hover:scale-110 transition" />

                    <p class="text-lg font-semibold">
                        Học viên
                    </p>

                </a>

                <!-- Gia sư -->
                <a href="{{ route('register.tutor') }}"
                    class="border rounded-xl p-6 text-center hover:shadow-xl hover:border-blue-500 transition group">

                    <x-heroicon-o-academic-cap
                        class="w-16 h-16 mx-auto mb-4 text-blue-500 group-hover:scale-110 transition" />

                    <p class="text-lg font-semibold">
                        Gia sư
                    </p>

                </a>

            </div>

            <!-- Quay lại -->
            <div class="text-center mt-8">
                <a href="{{ route('student.home') }}" class="text-blue-600 hover:underline">
                    ← Quay lại trang chủ
                </a>
            </div>

        </div>

    </div>
@endsection
