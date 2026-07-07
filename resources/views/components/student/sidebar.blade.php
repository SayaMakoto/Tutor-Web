@php
    $pendingApplications = auth()->check()
        ? \App\Models\Application::whereHas('classRequest.student', fn($q) => $q->where('user_id', auth()->id()))
            ->where('status', 'pending')->count()
        : 0;
@endphp

<aside
    class="w-64 bg-white border-r border-gray-100 shadow-sm sticky top-14.25 h-[calc(100vh-57px)] p-5 hidden md:flex flex-col gap-2 overflow-y-auto">

    {{-- User Info (nếu đã đăng nhập) --}}
    @auth
        <div class="flex items-center gap-3 p-3 bg-blue-50 rounded-xl mb-2">
            <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://i.pravatar.cc/40?u=' . Auth::user()->id }}"
                class="w-10 h-10 rounded-full object-cover border-2 border-blue-200" alt="Avatar">
            <div class="min-w-0">
                <p class="text-sm font-semibold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                <span class="text-xs bg-blue-100 text-blue-600 font-medium px-2 py-0.5 rounded-full">Học viên</span>
            </div>
        </div>
    @endauth

    {{-- Navigation --}}
    <nav class="flex flex-col gap-1">

        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 mt-1 mb-1">Menu</p>

        <!-- Trang chủ -->
        <a href="{{ route('student.home') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 text-sm font-medium
                  {{ request()->routeIs('student.home')
                      ? 'bg-blue-600 text-white shadow-sm'
                      : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600' }}">
            <i class="fas fa-home w-4 text-center"></i>
            <span>Trang chủ</span>
        </a>

        <!-- Lịch sử đăng lớp -->
        <a href="{{ route('classes.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 text-sm font-medium
                  {{ request()->routeIs('classes.index') && !request('status')
                      ? 'bg-blue-600 text-white shadow-sm'
                      : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600' }}">
            <i class="fas fa-history w-4 text-center"></i>
            <span>Lịch sử đăng lớp</span>
        </a>

        <!-- Lớp học hiện hành -->
        <a href="{{ route('classes.index', ['status' => 'assigned']) }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 text-sm font-medium
                  {{ request()->routeIs('classes.index') && request('status') === 'assigned'
                      ? 'bg-blue-600 text-white shadow-sm'
                      : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600' }}">
            <i class="fas fa-chalkboard-teacher w-4 text-center"></i>
            <span>Lớp học hiện hành</span>
        </a>

        <!-- Lời mời từ gia sư -->
        <a href="{{ route('student.applications.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 text-sm font-medium
                  {{ request()->routeIs('student.applications.*')
                      ? 'bg-blue-600 text-white shadow-sm'
                      : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600' }}">
            <i class="fas fa-envelope-open-text w-4 text-center"></i>
            <span class="flex-1">Lời mời từ gia sư</span>
            @if($pendingApplications > 0)
                <span class="inline-flex items-center justify-center min-w-[18px] h-[18px] px-1 rounded-full
                             bg-red-500 text-white text-[10px] font-bold leading-none shadow-sm">
                    {{ $pendingApplications > 99 ? '99+' : $pendingApplications }}
                </span>
            @endif
        </a>

        <!-- Đăng lớp -->
        @auth
            <a href="{{ route('create-class.step1') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 text-sm font-medium
                      {{ request()->routeIs('create-class.*')
                          ? 'bg-blue-600 text-white shadow-sm'
                          : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600' }}">
                <i class="fas fa-plus-circle w-4 text-center"></i>
                <span>Đăng lớp mới</span>
            </a>
        @endauth

        <div class="border-t border-gray-100 my-2"></div>

        <!-- Giới thiệu -->
        <a href="{{ route('about') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 text-sm font-medium
                  {{ request()->routeIs('about')
                      ? 'bg-blue-600 text-white shadow-sm'
                      : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600' }}">
            <i class="fas fa-info-circle w-4 text-center"></i>
            <span>Giới thiệu</span>
        </a>

    </nav>

</aside>
