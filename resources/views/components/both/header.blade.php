@php
    $pendingApplications = auth()->check()
        ? \App\Models\Application::whereHas('classRequest.student', fn($q) => $q->where('user_id', auth()->id()))
            ->where('status', 'pending')->count()
        : 0;
@endphp

<header class="bg-white border-b border-gray-100 shadow-sm sticky top-0 z-50">
    <div class="container mx-auto px-6 py-3 flex justify-between items-center gap-4">

        {{-- ── Logo ──────────────────────────────────────────── --}}
        <a href="{{ route('student.home') }}" class="flex items-center gap-2 group shrink-0">

            <div class="relative">
                {{-- Logo icon --}}
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-purple-600 to-indigo-600
                            flex items-center justify-center shadow-sm">
                    <i class="fas fa-graduation-cap text-white text-base"></i>
                </div>

                {{-- Dual-role badge --}}
                <div class="absolute -bottom-1 -right-1
                            w-4 h-4 rounded-full
                            bg-gradient-to-br from-blue-500 to-emerald-500
                            border-2 border-white
                            flex items-center justify-center shadow-sm">
                    <i class="fas fa-user-tie text-[7px] text-white"></i>
                </div>
            </div>

            <span class="text-xl font-bold bg-gradient-to-r from-purple-600 to-indigo-600
                         bg-clip-text text-transparent hidden sm:block">
                GiaSu247
            </span>

            {{-- Role badge --}}
            <span class="hidden lg:inline-flex items-center gap-1 text-[10px] font-semibold
                         bg-gradient-to-r from-blue-100 to-emerald-100
                         text-purple-700 px-2 py-0.5 rounded-full border border-purple-100">
                <i class="fas fa-user-tie text-[8px]"></i> GS & HV
            </span>

        </a>

        {{-- ── Navigation ───────────────────────────────────── --}}
        <nav class="hidden md:flex items-center gap-0.5 font-medium text-gray-600 flex-1 justify-center">

            {{-- ── Học viên section ─── --}}
            <div class="flex items-center gap-0.5 bg-blue-50/60 rounded-xl px-1.5 py-1 border border-blue-100/60">
                <span class="text-[10px] font-bold text-blue-500 uppercase tracking-wider px-1.5 select-none flex items-center gap-1">
                    <i class="fas fa-user-graduate text-[9px]"></i> HV
                </span>

                {{-- Trang chủ HV --}}
                <a href="{{ route('student.home') }}"
                   class="px-2.5 py-1.5 rounded-lg hover:bg-blue-100 hover:text-blue-700
                          transition-all duration-150 text-xs font-medium
                          {{ request()->routeIs('student.home') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600' }}">
                    <i class="fas fa-home mr-1 text-[10px]"></i>Trang chủ
                </a>

                {{-- Lớp học HV (dropdown) --}}
                <div class="relative group">
                    <button class="flex items-center gap-1 px-2.5 py-1.5 rounded-lg
                                   hover:bg-blue-100 hover:text-blue-700
                                   transition-all duration-150 text-xs font-medium text-gray-600">
                        <i class="fas fa-book-open mr-1 text-[10px]"></i>
                        Lớp học
                        <i class="fas fa-chevron-down text-[9px] ml-0.5 transition-transform duration-200 group-hover:rotate-180"></i>
                    </button>
                    <div class="absolute left-0 top-full pt-1.5 hidden group-hover:block z-50">
                        <div class="bg-white border border-gray-100 shadow-xl rounded-xl w-48 p-1.5">
                            <a href="{{ route('classes.index') }}"
                               class="flex items-center gap-2 px-3 py-2 rounded-lg
                                      hover:bg-blue-50 hover:text-blue-700 transition text-xs font-medium">
                                <i class="fas fa-history text-gray-400 w-4 text-center"></i>
                                Lịch sử đăng lớp
                            </a>
                            <a href="{{ route('classes.index', ['status' => 'assigned']) }}"
                               class="flex items-center gap-2 px-3 py-2 rounded-lg
                                      hover:bg-blue-50 hover:text-blue-700 transition text-xs font-medium">
                                <i class="fas fa-chalkboard-teacher text-gray-400 w-4 text-center"></i>
                                Lớp đang học
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Lời mời --}}
                <a href="{{ route('student.applications.index') }}"
                   class="relative px-2.5 py-1.5 rounded-lg hover:bg-blue-100 hover:text-blue-700
                           transition-all duration-150 text-xs font-medium
                           {{ request()->routeIs('student.applications.*') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600' }}">
                    <i class="fas fa-envelope-open-text mr-1 text-[10px]"></i>Lời mời
                    @if($pendingApplications > 0)
                        <span class="absolute -top-1.5 -right-2 inline-flex items-center justify-center min-w-[16px] h-[16px] px-0.5 rounded-full
                                     bg-red-500 text-white text-[9px] font-bold leading-none shadow-sm">
                            {{ $pendingApplications > 99 ? '99+' : $pendingApplications }}
                        </span>
                    @endif
                </a>

                {{-- Đăng lớp --}}
                <a href="{{ route('create-class.step1') }}"
                   class="px-2.5 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-700
                          text-white transition-all duration-150 text-xs font-semibold shadow-sm
                          {{ request()->routeIs('create-class.*') ? 'ring-2 ring-blue-300' : '' }}">
                    <i class="fas fa-plus mr-1 text-[10px]"></i>Đăng lớp
                </a>
            </div>

            <div class="w-px h-6 bg-gray-200 mx-1.5"></div>

            {{-- ── Gia sư section ─── --}}
            <div class="flex items-center gap-0.5 bg-emerald-50/60 rounded-xl px-1.5 py-1 border border-emerald-100/60">
                <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider px-1.5 select-none flex items-center gap-1">
                    <i class="fas fa-chalkboard-teacher text-[9px]"></i> GS
                </span>

                {{-- Trang chủ GS --}}
                <a href="{{ route('tutor.home') }}"
                   class="px-2.5 py-1.5 rounded-lg hover:bg-emerald-100 hover:text-emerald-700
                          transition-all duration-150 text-xs font-medium
                          {{ request()->routeIs('tutor.home') ? 'bg-emerald-600 text-white shadow-sm' : 'text-gray-600' }}">
                    <i class="fas fa-gauge-high mr-1 text-[10px]"></i>Dashboard
                </a>

                {{-- Quản lý lớp GS (dropdown) --}}
                <div class="relative group">
                    <button class="flex items-center gap-1 px-2.5 py-1.5 rounded-lg
                                   hover:bg-emerald-100 hover:text-emerald-700
                                   transition-all duration-150 text-xs font-medium text-gray-600">
                        <i class="fas fa-book-open mr-1 text-[10px]"></i>
                        Lớp học
                        <i class="fas fa-chevron-down text-[9px] ml-0.5 transition-transform duration-200 group-hover:rotate-180"></i>
                    </button>
                    <div class="absolute left-0 top-full pt-1.5 hidden group-hover:block z-50">
                        <div class="bg-white border border-gray-100 shadow-xl rounded-xl w-48 p-1.5">
                            <a href="{{ route('tutor.classes.index') }}"
                               class="flex items-center gap-2 px-3 py-2 rounded-lg
                                      hover:bg-emerald-50 hover:text-emerald-700 transition text-xs font-medium">
                                <i class="fas fa-search text-gray-400 w-4 text-center"></i>
                                Tìm lớp tuyển dạy
                            </a>
                            <a href="{{ route('tutor.classes.assigned') }}"
                               class="flex items-center gap-2 px-3 py-2 rounded-lg
                                      hover:bg-emerald-50 hover:text-emerald-700 transition text-xs font-medium">
                                <i class="fas fa-paper-plane text-gray-400 w-4 text-center"></i>
                                Lớp đã ứng tuyển
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Thanh toán --}}
                @auth
                    <a href="{{ route('payment.wallet') }}"
                       class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg
                              hover:bg-emerald-100 hover:text-emerald-700
                              transition-all duration-150 text-xs font-medium
                              {{ request()->routeIs('payment.*') ? 'bg-emerald-600 text-white shadow-sm' : 'text-gray-600' }}">
                        <i class="fas fa-receipt text-[10px]"></i>
                        Thanh toán
                    </a>
                @endauth
            </div>

        </nav>

        {{-- ── Avatar / Right side ─────────────────────────── --}}
        <div class="flex items-center gap-2 shrink-0">
            @auth
                <x-partials.user-dropdown />
            @else
                <a href="{{ route('login') }}"
                   class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white
                          px-4 py-2 rounded-xl font-semibold text-sm shadow-sm
                          hover:shadow-md hover:from-purple-700 hover:to-indigo-700
                          transition-all duration-200">
                    Đăng nhập
                </a>
            @endauth
        </div>

    </div>
</header>
