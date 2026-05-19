@extends('layouts.student')

@section('content')
    <x-partials.slider />

    {{-- Giới thiệu --}}
    <div class="bg-white p-10 rounded-2xl shadow mb-10 text-center">
        <h2 class="text-3xl font-bold mb-4">Về chúng tôi</h2>
        <p class="text-gray-600 max-w-2xl mx-auto">
            Chúng tôi kết nối gia sư và học viên một cách nhanh chóng, uy tín và hiệu quả.
            Hàng nghìn lớp học được cập nhật mỗi ngày.
        </p>
    </div>

    {{-- Lớp mới nhất --}}
    <div class="mb-10">
        <h2 class="text-2xl font-bold mb-6">Lớp mới nhất</h2>

        @if ($classes && $classes instanceof \Illuminate\Support\Collection && $classes->count())
            <div class="grid md:grid-cols-3 gap-6">
                @foreach ($classes as $class)
                    <x-partials.class-card :classRequest="$class" />
                @endforeach
            </div>
        @else
            <p class="text-gray-500">Hiện chưa có lớp học nào.</p>
        @endif
    </div>

    {{-- Học phí tham khảo --}}
    <div class="bg-gray-50 p-10 rounded-2xl mb-10">
        <h2 class="text-2xl font-bold mb-6 text-center">Học phí tham khảo</h2>

        <div class="grid md:grid-cols-3 gap-6 text-center">
            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="font-semibold text-lg mb-2">Tiểu học</h3>
                <p class="text-yellow-500 text-xl font-bold">100k - 150k/buổi</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="font-semibold text-lg mb-2">THCS</h3>
                <p class="text-yellow-500 text-xl font-bold">150k - 250k/buổi</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="font-semibold text-lg mb-2">THPT</h3>
                <p class="text-yellow-500 text-xl font-bold">200k - 400k/buổi</p>
            </div>
        </div>
    </div>

    @auth
        @if (in_array(auth()->user()->role, ['student']))
            {{-- Kêu gọi gia sư --}}
            <div class="bg-blue-600 text-white p-10 rounded-2xl text-center">
                <h2 class="text-3xl font-bold mb-4">Bạn là gia sư?</h2>
                <p class="mb-6">Đăng ký ngay để nhận lớp phù hợp</p>
                <a href="{{ route('become-tutor') }}" class="bg-yellow-400 text-black px-6 py-3 rounded-xl font-semibold">
                    Đăng ký làm gia sư
                </a>
            </div>
        @endif
    @endauth

    @guest
        {{-- Kêu gọi gia sư cho khách --}}
        <div class="bg-blue-600 text-white p-10 rounded-2xl text-center">
            <h2 class="text-3xl font-bold mb-4">Bạn là gia sư?</h2>
            <p class="mb-6">Đăng ký ngay để nhận lớp phù hợp</p>
            <a href="{{ route('register.tutor') }}" class="bg-yellow-400 text-black px-6 py-3 rounded-xl font-semibold">
                Đăng ký làm gia sư
            </a>
        </div>
    @endguest
@endsection
