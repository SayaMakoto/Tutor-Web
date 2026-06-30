@extends('layouts.auth')

@section('content')
    <div
        class="min-h-screen flex items-center justify-center bg-linear-to-br from-blue-600 via-indigo-600 to-purple-700 relative overflow-hidden px-4">
        
        <div class="absolute -top-20 -left-20 w-64 h-64 bg-white/10 rounded-full pointer-events-none"></div>
        <div class="absolute -bottom-25 -right-15 w-80 h-80 bg-white/10 rounded-full pointer-events-none"></div>
        
        <div class="relative z-10 bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md">
            
            <div class="text-center mb-7">
                <h1 class="text-2xl font-bold text-gray-800">Quên mật khẩu</h1>
                <p class="text-sm text-gray-500 mt-1">Nhập email để nhận hướng dẫn đặt lại (demo)</p>
            </div>

            @if(session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('forgot-password.store') }}">
                @csrf
                
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fa-solid fa-envelope text-sm"></i>
                        </span>
                        <input type="email" name="email" required
                            class="border border-gray-200 rounded-xl pl-10 pr-4 py-3 w-full text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition"
                            placeholder="example@email.com">
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-linear-to-r from-blue-600 to-indigo-600 text-white py-3 rounded-xl font-semibold hover:shadow-lg hover:from-blue-700 hover:to-indigo-700 transition-all">
                    Gửi yêu cầu
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
