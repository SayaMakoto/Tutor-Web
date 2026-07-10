@php
    $tutor = auth()->user()->tutor;
@endphp

<aside
    class="w-64 bg-white border-r border-gray-100 shadow-sm
           sticky top-14.25 h-[calc(100vh-57px)]
           p-5 hidden md:flex flex-col gap-2 overflow-y-auto">

    {{-- User Info --}}
    @auth
        <div class="flex items-center gap-3 p-3 bg-green-50 rounded-xl mb-2">

            <img src="{{ Auth::user()->avatar
                ? asset('storage/' . Auth::user()->avatar)
                : 'https://i.pravatar.cc/40?u=' . Auth::user()->id }}"
                class="w-10 h-10 rounded-full object-cover border-2 border-green-200" alt="Avatar">

            <div class="min-w-0">
                <p class="text-sm font-semibold text-gray-800 truncate">
                    {{ Auth::user()->name }}
                </p>

                <span class="text-xs bg-green-100 text-green-600 font-medium px-2 py-0.5 rounded-full">
                    Gia sư
                </span>
            </div>

        </div>
    @endauth


    {{-- Navigation --}}
    <nav class="flex flex-col gap-1">

        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 mt-1 mb-1">
            Menu
        </p>

        <!-- Trang chủ -->
        <a href="{{ route('tutor.home') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl
                   transition-all duration-150 text-sm font-medium
                   {{ request()->routeIs('tutor.home')
                       ? 'bg-green-600 text-white shadow-sm'
                       : 'text-gray-600 hover:bg-green-50 hover:text-green-600' }}">

            <i class="fas fa-home w-4 text-center"></i>

            <span>Trang chủ</span>

        </a>


        <!-- Tìm lớp -->
        <a href="{{ route('tutor.classes.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl
                   transition-all duration-150 text-sm font-medium
                   {{ request()->routeIs('tutor.classes.index')
                       ? 'bg-green-600 text-white shadow-sm'
                       : 'text-gray-600 hover:bg-green-50 hover:text-green-600' }}">

            <i class="fas fa-search w-4 text-center"></i>

            <span>Tìm lớp</span>

        </a>


        <!-- Lớp đã nhận -->
        <a href="{{ route('tutor.classes.assigned') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl
                   transition-all duration-150 text-sm font-medium
                   {{ request()->routeIs('tutor.classes.assigned')
                       ? 'bg-green-600 text-white shadow-sm'
                       : 'text-gray-600 hover:bg-green-50 hover:text-green-600' }}">

            <i class="fas fa-chalkboard-teacher w-4 text-center"></i>

            <span>Lớp đã nhận</span>

        </a>


        <!-- Lịch dạy -->
        <a href="#"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl
                   transition-all duration-150 text-sm font-medium
                   text-gray-600 hover:bg-green-50 hover:text-green-600">

            <i class="fas fa-calendar-alt w-4 text-center"></i>

            <span>Lịch dạy</span>

        </a>


        <!-- Thu nhập -->
        <a href="#"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl
                   transition-all duration-150 text-sm font-medium
                   text-gray-600 hover:bg-green-50 hover:text-green-600">

            <i class="fas fa-wallet w-4 text-center"></i>

            <span>Thu nhập</span>

        </a>


        {{-- Lịch sử Thanh toán & Bảo lãnh (Escrow) --}}
        <a href="{{ route('payment.wallet') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl
                   transition-all duration-150 text-sm font-medium
                   {{ request()->routeIs('payment.*')
                       ? 'bg-green-600 text-white shadow-sm'
                       : 'text-gray-600 hover:bg-green-50 hover:text-green-600' }}">

            <i class="fas fa-receipt w-4 text-center"></i>

            <span class="flex-1">Thanh toán</span>
        </a>


        <!-- Cập nhật hồ sơ -->
        @if ($tutor && $tutor->status === 'pending')
            <a href="{{ route('tutor.profile.edit') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl
                       transition-all duration-150 text-sm font-medium
                       {{ request()->routeIs('tutor.profile.edit')
                           ? 'bg-green-600 text-white shadow-sm'
                           : 'text-gray-600 hover:bg-green-50 hover:text-green-600' }}">

                <i class="fas fa-user-edit w-4 text-center"></i>

                <span>Cập nhật hồ sơ</span>

            </a>
        @endif


        <div class="border-t border-gray-100 my-2"></div>


        <!-- Giới thiệu -->
        <a href="{{ route('about') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl
                   transition-all duration-150 text-sm font-medium
                   {{ request()->routeIs('about')
                       ? 'bg-green-600 text-white shadow-sm'
                       : 'text-gray-600 hover:bg-green-50 hover:text-green-600' }}">

            <i class="fas fa-info-circle w-4 text-center"></i>

            <span>Giới thiệu</span>

        </a>

    </nav>

</aside>
