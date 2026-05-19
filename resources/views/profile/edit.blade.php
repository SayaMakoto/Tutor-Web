@extends('layouts.auth')

@section('content')
    <div class="min-h-screen bg-gray-50 py-10">
        <div class="max-w-4xl mx-auto bg-white shadow-xl rounded-2xl p-8">

            <h2 class="text-2xl font-bold mb-6 text-gray-800">
                Thông tin cá nhân
            </h2>
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                    {{-- Avatar --}}
                    <div class="flex flex-col items-center">
                        <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://i.pravatar.cc/40' }}"
                            class="w-32 h-32 rounded-full object-cover border shadow">

                        <label class="mt-4 text-sm font-medium text-gray-600">
                            Đổi avatar
                        </label>

                        <input type="file" name="avatar"
                            class="mt-2 block w-full text-sm text-gray-500
                               file:mr-4 file:py-2 file:px-4
                               file:rounded-full file:border-0
                               file:text-sm file:font-semibold
                               file:bg-blue-50 file:text-blue-600
                               hover:file:bg-blue-100">


                    </div>

                    {{-- Thông tin --}}
                    <div class="md:col-span-2 space-y-5">

                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Họ và tên
                            </label>
                            <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}"
                                class="mt-1 w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">

                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Email
                            </label>
                            <input type="email" value="{{ Auth::user()->email }}" disabled
                                class="mt-1 w-full border rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Số điện thoại
                            </label>
                            <input type="text" name="phone" value="{{ old('phone', Auth::user()->phone) }}"
                                class="mt-1 w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                                required>

                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Ngày sinh
                            </label>

                            <input type="date" name="date_of_birth"
                                value="{{ old('date_of_birth', Auth::user()->date_of_birth) }}"
                                class="mt-1 w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                                required>

                        </div>

                        <div class="pt-4 flex items-center gap-4">
                            <button type="submit"
                                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition shadow">
                                Lưu thay đổi
                            </button>

                            @php
                                $role = Auth::user()->role;

                                if ($role === 'tutor') {
                                    $homeRoute = route('tutor.home');
                                } else {
                                    // student hoặc both
                                    $homeRoute = route('student.home');
                                }
                            @endphp

                            <a href="{{ $homeRoute }}"
                                class="px-6 py-2 rounded-lg border border-gray-300 hover:bg-gray-100 transition">
                                Quay về trang chủ
                            </a>
                        </div>

                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection
