@extends('layouts.student')

@section('content')
    @auth
        @if (is_null(auth()->user()->phone) || is_null(auth()->user()->date_of_birth))
            <div
                class="mb-6 p-4 bg-linear-to-r from-red-50 to-orange-50 border border-red-100 rounded-2xl flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center text-red-600">
                        <i class="fas fa-exclamation-triangle text-lg"></i>
                    </div>
                    <div class="text-left">
                        <h4 class="font-bold text-gray-800 text-sm">Hồ sơ chưa hoàn thiện!</h4>
                        <p class="text-xs text-gray-500 mt-0.5">Vui lòng cập nhật Số điện thoại và Ngày sinh để tài khoản hoạt
                            động bình thường.</p>
                    </div>
                </div>
                <a href="{{ route('profile.edit') }}"
                    class="bg-red-600 hover:bg-red-700 text-white text-xs font-bold px-4 py-2 rounded-xl transition shadow-sm whitespace-nowrap">
                    Cập nhật ngay
                </a>
            </div>
        @endif
    @endauth
    {{-- Hero Banner --}}
    <x-partials.slider />

    {{-- Giới thiệu --}}
    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 mb-8">
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Về GiaSu247</h2>
            <p class="text-gray-500 max-w-2xl mx-auto text-sm leading-relaxed">
                Chúng tôi kết nối gia sư và học viên một cách nhanh chóng, uy tín và hiệu quả.
                Hàng nghìn lớp học được cập nhật mỗi ngày.
            </p>
        </div>
        <div class="grid grid-cols-3 gap-4 max-w-lg mx-auto text-center">
            <div class="flex flex-col items-center gap-1 p-3 rounded-xl bg-blue-50">
                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-chalkboard-teacher text-blue-600 text-lg"></i>
                </div>
                <p class="text-xl font-bold text-blue-600">500+</p>
                <p class="text-xs text-gray-500">Gia sư</p>
            </div>
            <div class="flex flex-col items-center gap-1 p-3 rounded-xl bg-indigo-50">
                <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-book-open text-indigo-600 text-lg"></i>
                </div>
                <p class="text-xl font-bold text-indigo-600">1.000+</p>
                <p class="text-xs text-gray-500">Lớp học</p>
            </div>
            <div class="flex flex-col items-center gap-1 p-3 rounded-xl bg-amber-50">
                <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-star text-amber-500 text-lg"></i>
                </div>
                <p class="text-xl font-bold text-amber-500">4.8</p>
                <p class="text-xs text-gray-500">Đánh giá</p>
            </div>
        </div>
    </div>

    {{-- Lớp mới nhất --}}
    <div class="mb-8">
        <div class="flex justify-between items-center mb-5">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Lớp mới nhất</h2>
                <p class="text-sm text-gray-500 mt-0.5">Các lớp học vừa được đăng gần đây</p>
            </div>
            <a href="{{ route('classes.index') }}"
                class="text-sm font-semibold text-blue-600 hover:text-indigo-600 transition flex items-center gap-1">
                Xem tất cả <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>

        @if ($classes && $classes instanceof \Illuminate\Support\Collection && $classes->count())
            <div class="grid md:grid-cols-3 gap-5">
                @foreach ($classes as $class)
                    <x-partials.class-card :classRequest="$class" />
                @endforeach
            </div>
        @else
            <div class="text-center py-14 bg-white rounded-2xl border border-dashed border-gray-200">
                <i class="fas fa-book-open text-gray-300 text-4xl mb-3"></i>
                <p class="text-gray-500 font-medium">Hiện chưa có lớp học nào</p>
                <p class="text-gray-400 text-sm mt-1">Hãy quay lại sau nhé!</p>
            </div>
        @endif
    </div>

    {{-- Học phí tham khảo --}}
    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 mb-8">
        <div class="text-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">Học phí tham khảo</h2>
            <p class="text-sm text-gray-500 mt-1">Mức học phí phổ biến theo cấp học</p>
        </div>
        <div class="grid md:grid-cols-3 gap-4 text-center">
            <div class="p-5 rounded-xl border border-blue-100 bg-blue-50 hover:shadow-md transition">
                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-child text-blue-600"></i>
                </div>
                <h3 class="font-semibold text-gray-700 mb-1">Tiểu học</h3>
                <p class="text-blue-600 text-lg font-bold">100k – 150k</p>
                <p class="text-xs text-gray-400 mt-0.5">/ buổi học</p>
            </div>
            <div class="p-5 rounded-xl border border-indigo-100 bg-indigo-50 hover:shadow-md transition">
                <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-user-graduate text-indigo-600"></i>
                </div>
                <h3 class="font-semibold text-gray-700 mb-1">THCS</h3>
                <p class="text-indigo-600 text-lg font-bold">150k – 250k</p>
                <p class="text-xs text-gray-400 mt-0.5">/ buổi học</p>
            </div>
            <div class="p-5 rounded-xl border border-purple-100 bg-purple-50 hover:shadow-md transition">
                <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-graduation-cap text-purple-600"></i>
                </div>
                <h3 class="font-semibold text-gray-700 mb-1">THPT</h3>
                <p class="text-purple-600 text-lg font-bold">200k – 400k</p>
                <p class="text-xs text-gray-400 mt-0.5">/ buổi học</p>
            </div>
        </div>
    </div>

    {{-- CTA Section --}}
    @auth
        @if (in_array(auth()->user()->role, ['student']))
            <div
                class="relative bg-linear-to-br from-blue-600 via-indigo-600 to-purple-700 
                        text-white p-10 rounded-2xl text-center overflow-hidden mb-6">
                <div class="absolute top-0 right-0 w-40 h-40 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                <h2 class="text-2xl font-bold mb-2 relative z-10">Bạn là gia sư?</h2>
                <p class="mb-6 text-blue-100 text-sm relative z-10">Đăng ký ngay để nhận lớp phù hợp với chuyên môn của bạn</p>
                <a href="{{ route('become-tutor') }}"
                    class="relative z-10 inline-flex items-center gap-2 bg-yellow-400 text-gray-900 
                          px-7 py-3 rounded-xl font-bold hover:bg-yellow-300 transition shadow-lg">
                    <i class="fas fa-chalkboard-teacher"></i>
                    Đăng ký làm gia sư
                </a>
            </div>
        @endif
    @endauth

    @guest
        <div
            class="relative bg-linear-to-br from-blue-600 via-indigo-600 to-purple-700 
                    text-white p-10 rounded-2xl text-center overflow-hidden mb-6">
            <div class="absolute top-0 right-0 w-40 h-40 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
            <h2 class="text-2xl font-bold mb-2 relative z-10">Bạn là gia sư?</h2>
            <p class="mb-6 text-blue-100 text-sm relative z-10">Đăng ký ngay để nhận lớp phù hợp với chuyên môn của bạn</p>
            <a href="{{ route('register.tutor') }}"
                class="relative z-10 inline-flex items-center gap-2 bg-yellow-400 text-gray-900 
                      px-7 py-3 rounded-xl font-bold hover:bg-yellow-300 transition shadow-lg">
                <i class="fas fa-chalkboard-teacher"></i>
                Đăng ký làm gia sư
            </a>
        </div>
    @endguest

@endsection
