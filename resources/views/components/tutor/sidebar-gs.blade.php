@php
    $tutor = auth()->user()->tutor;
@endphp

<aside class="w-64 bg-white shadow-md sticky top-16 h-[calc(100vh-4rem)] p-6 hidden md:block">
    <h2 class="text-xl font-bold mb-6">Danh mục</h2>
    <ul class="space-y-4">
        <li>
            <a href=" {{ route('tutor.home') }}" class="block hover:text-blue-600">
                Trang chủ
            </a>
        </li>
        <li><a href="{{ route('tutor.classes.index') }}" class="block hover:text-blue-600">Tìm lớp</a></li>
        <li><a href="{{ route('tutor.classes.assigned') }}" class="block hover:text-blue-600">Lớp đã nhận</a></li>
        <li><a href="#" class="block hover:text-blue-600">Lịch dạy</a></li>
        <li><a href="#" class="block hover:text-blue-600">Thu nhập</a></li>
        @if ($tutor && $tutor->status === 'pending')
            <li>
                <a href="{{ route('tutor.profile.edit') }}"
                    class="block px-4 py-2 rounded-xl border-2 font-semibold transition
       {{ request()->routeIs('tutor.profile.edit')
           ? 'border-blue-600 text-blue-600 bg-blue-50'
           : 'border-gray-300 text-gray-700 hover:border-blue-500 hover:text-blue-600 hover:bg-blue-50' }}">
                    Cập nhật hồ sơ
                </a>
            </li>
        @endif

        <li>
            <a href="{{ route('about') }}" class="block hover:text-blue-600">
                Giới thiệu
            </a>
        </li>
    </ul>
</aside>
