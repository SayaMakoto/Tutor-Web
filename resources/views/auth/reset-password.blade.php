@extends('layouts.auth')

@section('content')
    <div
        class="min-h-screen flex items-center justify-center bg-linear-to-br from-blue-600 via-indigo-600 to-purple-700 relative overflow-hidden px-4">
        
        <div class="absolute -top-20 -left-20 w-64 h-64 bg-white/10 rounded-full pointer-events-none"></div>
        <div class="absolute -bottom-25 -right-15 w-80 h-80 bg-white/10 rounded-full pointer-events-none"></div>
        
        <div class="relative z-10 bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md">
            
            <div class="text-center mb-7">
                <h1 class="text-2xl font-bold text-gray-800">Đặt lại mật khẩu</h1>
                <p class="text-sm text-gray-500 mt-1">Nhập mật khẩu mới cho tài khoản của bạn</p>
            </div>

            @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm font-medium">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('reset-password.store') }}" x-data="{ showNew: false, showConfirm: false }">
                @csrf
                
                <input type="hidden" name="email" value="{{ session('reset_email', old('email')) }}">

                <!-- Mật khẩu mới -->
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu mới</label>
                    <div class="relative rounded-xl shadow-sm">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fa-solid fa-lock text-sm"></i>
                        </span>
                        <input :type="showNew ? 'text' : 'password'" name="password" required
                            class="border border-gray-200 rounded-xl pl-10 pr-12 py-3 w-full text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition"
                            placeholder="••••••••">
                        <button type="button" @click="showNew = !showNew"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-blue-500 transition">
                            <i :class="showNew ? 'fas fa-eye-slash' : 'fas fa-eye'" class="text-sm"></i>
                        </button>
                    </div>
                </div>

                <!-- Xác nhận mật khẩu mới -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Xác nhận mật khẩu</label>
                    <div class="relative rounded-xl shadow-sm">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fa-solid fa-check-circle text-sm"></i>
                        </span>
                        <input :type="showConfirm ? 'text' : 'password'" name="password_confirmation" required
                            class="border border-gray-200 rounded-xl pl-10 pr-12 py-3 w-full text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition"
                            placeholder="••••••••">
                        <button type="button" @click="showConfirm = !showConfirm"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-blue-500 transition">
                            <i :class="showConfirm ? 'fas fa-eye-slash' : 'fas fa-eye'" class="text-sm"></i>
                        </button>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-linear-to-r from-blue-600 to-indigo-600 text-white py-3 rounded-xl font-semibold hover:shadow-lg hover:from-blue-700 hover:to-indigo-700 transition-all">
                    Đổi mật khẩu
                </button>
            </form>

            <div class="text-center mt-6">
                <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-gray-800 transition">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Quay lại đăng nhập
                </a>
            </div>
            
        </div>
    </div>
@endsection
