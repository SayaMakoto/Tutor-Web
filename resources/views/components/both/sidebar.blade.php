@php
    $tutor    = auth()->user()?->tutor;
    $wallet   = auth()->user()?->wallet;
    $xuBalance = $wallet?->balance ?? 0;
@endphp

<aside class="w-64 bg-white border-r border-gray-100 shadow-sm
               sticky top-14.25 h-[calc(100vh-57px)]
               hidden md:flex flex-col overflow-y-auto">

    {{-- ── User card ─────────────────────────────────────── --}}
    @auth
        <div class="p-4 border-b border-gray-100">
            <div class="flex items-center gap-3 p-3 rounded-xl
                        bg-gradient-to-br from-purple-50 to-indigo-50 border border-purple-100">
                <div class="relative shrink-0">
                    <img src="{{ Auth::user()->avatar
                        ? asset('storage/' . Auth::user()->avatar)
                        : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=7c3aed&color=fff' }}"
                         class="w-11 h-11 rounded-full object-cover border-2 border-purple-200"
                         alt="Avatar">
                    {{-- Dual role badge --}}
                    <div class="absolute -bottom-0.5 -right-0.5 w-4 h-4 rounded-full
                                bg-gradient-to-br from-blue-500 to-emerald-500
                                border-2 border-white flex items-center justify-center shadow">
                        <i class="fas fa-user-tie text-[6px] text-white"></i>
                    </div>
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                    <div class="flex items-center gap-1 mt-0.5">
                        <span class="text-[10px] bg-blue-100 text-blue-600 font-semibold px-1.5 py-0.5 rounded-full leading-none">HV</span>
                        <span class="text-gray-300 text-[10px]">•</span>
                        <span class="text-[10px] bg-emerald-100 text-emerald-600 font-semibold px-1.5 py-0.5 rounded-full leading-none">GS</span>
                    </div>
                </div>
            </div>
        </div>
    @endauth

    {{-- ── Navigation ──────────────────────────────────────── --}}
    <nav class="flex flex-col gap-0.5 p-3 flex-1">

        {{-- ════════════════════════════════════════════════════
             MỤC HỌC VIÊN
        ════════════════════════════════════════════════════ --}}
        <div class="mb-1">
            <div class="flex items-center gap-2 px-2 py-1.5 mb-1">
                <div class="w-5 h-5 rounded-md bg-blue-600 flex items-center justify-center shadow-sm shrink-0">
                    <i class="fas fa-user-graduate text-white text-[9px]"></i>
                </div>
                <p class="text-[11px] font-bold text-blue-600 uppercase tracking-wider">Học viên</p>
            </div>

            {{-- Trang chủ HV --}}
            <a href="{{ route('student.home') }}"
               class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-sm font-medium transition-all duration-150
                      {{ request()->routeIs('student.home')
                         ? 'bg-blue-600 text-white shadow-sm'
                         : 'text-gray-600 hover:bg-blue-50 hover:text-blue-700' }}">
                <i class="fas fa-home w-4 text-center text-[13px]"></i>
                <span>Trang chủ</span>
            </a>

            {{-- Lịch sử đăng lớp --}}
            <a href="{{ route('classes.index') }}"
               class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-sm font-medium transition-all duration-150
                      {{ request()->routeIs('classes.index') && !request('status')
                         ? 'bg-blue-600 text-white shadow-sm'
                         : 'text-gray-600 hover:bg-blue-50 hover:text-blue-700' }}">
                <i class="fas fa-history w-4 text-center text-[13px]"></i>
                <span>Lịch sử đăng lớp</span>
            </a>

            {{-- Lớp đang học --}}
            <a href="{{ route('classes.index', ['status' => 'assigned']) }}"
               class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-sm font-medium transition-all duration-150
                      {{ request()->routeIs('classes.index') && request('status') === 'assigned'
                         ? 'bg-blue-600 text-white shadow-sm'
                         : 'text-gray-600 hover:bg-blue-50 hover:text-blue-700' }}">
                <i class="fas fa-chalkboard-teacher w-4 text-center text-[13px]"></i>
                <span>Lớp đang học</span>
            </a>

            {{-- Lời mời gia sư --}}
            <a href="{{ route('student.applications.index') }}"
               class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-sm font-medium transition-all duration-150
                      {{ request()->routeIs('student.applications.*')
                         ? 'bg-blue-600 text-white shadow-sm'
                         : 'text-gray-600 hover:bg-blue-50 hover:text-blue-700' }}">
                <i class="fas fa-envelope-open-text w-4 text-center text-[13px]"></i>
                <span>Lời mời gia sư</span>
            </a>

            {{-- Đăng lớp mới --}}
            <a href="{{ route('create-class.step1') }}"
               class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-sm font-medium transition-all duration-150
                      {{ request()->routeIs('create-class.*')
                         ? 'bg-blue-600 text-white shadow-sm'
                         : 'text-gray-600 hover:bg-blue-50 hover:text-blue-700' }}">
                <i class="fas fa-plus-circle w-4 text-center text-[13px]"></i>
                <span>Đăng lớp mới</span>
            </a>
        </div>

        {{-- Divider --}}
        <div class="flex items-center gap-2 my-1 px-2">
            <div class="flex-1 h-px bg-gradient-to-r from-blue-100 via-purple-100 to-emerald-100"></div>
        </div>

        {{-- ════════════════════════════════════════════════════
             MỤC GIA SƯ
        ════════════════════════════════════════════════════ --}}
        <div class="mb-1">
            <div class="flex items-center gap-2 px-2 py-1.5 mb-1">
                <div class="w-5 h-5 rounded-md bg-emerald-600 flex items-center justify-center shadow-sm shrink-0">
                    <i class="fas fa-chalkboard-teacher text-white text-[9px]"></i>
                </div>
                <p class="text-[11px] font-bold text-emerald-600 uppercase tracking-wider">Gia sư</p>
            </div>

            {{-- Dashboard GS --}}
            <a href="{{ route('tutor.home') }}"
               class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-sm font-medium transition-all duration-150
                      {{ request()->routeIs('tutor.home')
                         ? 'bg-emerald-600 text-white shadow-sm'
                         : 'text-gray-600 hover:bg-emerald-50 hover:text-emerald-700' }}">
                <i class="fas fa-gauge-high w-4 text-center text-[13px]"></i>
                <span>Dashboard</span>
            </a>

            {{-- Tìm lớp --}}
            <a href="{{ route('tutor.classes.index') }}"
               class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-sm font-medium transition-all duration-150
                      {{ request()->routeIs('tutor.classes.index')
                         ? 'bg-emerald-600 text-white shadow-sm'
                         : 'text-gray-600 hover:bg-emerald-50 hover:text-emerald-700' }}">
                <i class="fas fa-magnifying-glass w-4 text-center text-[13px]"></i>
                <span>Tìm lớp tuyển dạy</span>
            </a>

            {{-- Lớp đã nhận --}}
            <a href="{{ route('tutor.classes.assigned') }}"
               class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-sm font-medium transition-all duration-150
                      {{ request()->routeIs('tutor.classes.assigned')
                         ? 'bg-emerald-600 text-white shadow-sm'
                         : 'text-gray-600 hover:bg-emerald-50 hover:text-emerald-700' }}">
                <i class="fas fa-paper-plane w-4 text-center text-[13px]"></i>
                <span>Lớp đã ứng tuyển</span>
            </a>

            {{-- Ví Xu --}}
            <a href="{{ route('payment.wallet') }}"
               class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-sm font-medium transition-all duration-150
                      {{ request()->routeIs('payment.*')
                         ? 'bg-emerald-600 text-white shadow-sm'
                         : 'text-gray-600 hover:bg-emerald-50 hover:text-emerald-700' }}">
                <i class="fas fa-coins w-4 text-center text-[13px]"></i>
                <span class="flex-1">Ví Xu</span>
                <span class="text-xs font-semibold px-2 py-0.5 rounded-full
                             {{ request()->routeIs('payment.*')
                                ? 'bg-white/20 text-white'
                                : 'bg-emerald-100 text-emerald-700' }}">
                    {{ number_format($xuBalance) }}
                </span>
            </a>

            {{-- Cập nhật hồ sơ (chỉ hiện khi còn pending) --}}
            @if($tutor && $tutor->status === 'pending')
                <a href="{{ route('tutor.profile.edit') }}"
                   class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-sm font-medium transition-all duration-150
                          {{ request()->routeIs('tutor.profile.edit')
                             ? 'bg-emerald-600 text-white shadow-sm'
                             : 'text-gray-600 hover:bg-emerald-50 hover:text-emerald-700' }}">
                    <i class="fas fa-user-edit w-4 text-center text-[13px]"></i>
                    <span class="flex-1">Cập nhật hồ sơ</span>
                    <span class="inline-flex w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                </a>
            @endif
        </div>

        {{-- Divider --}}
        <div class="h-px bg-gray-100 my-1"></div>

        {{-- ── Chung ──────────────────────────────────────── --}}
        <a href="{{ route('about') }}"
           class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-sm font-medium transition-all duration-150
                  {{ request()->routeIs('about')
                     ? 'bg-gray-800 text-white shadow-sm'
                     : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700' }}">
            <i class="fas fa-info-circle w-4 text-center text-[13px]"></i>
            <span>Giới thiệu</span>
        </a>

    </nav>

</aside>
