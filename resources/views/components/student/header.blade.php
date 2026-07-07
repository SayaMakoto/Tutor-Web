@php
    $pendingApplications = auth()->check()
        ? \App\Models\Application::whereHas('classRequest.student', fn($q) => $q->where('user_id', auth()->id()))
            ->where('status', 'pending')->count()
        : 0;
@endphp

<header class="bg-white border-b border-gray-100 shadow-sm sticky top-0 z-50">
    <div class="container mx-auto px-6 py-3 flex justify-between items-center">

        <!-- Logo -->
        <a href="{{ route('student.home') }}" class="flex items-center gap-2 group">

            <div class="relative">

                <!-- Logo chính -->
                <div
                    class="w-9 h-9 rounded-xl
                    bg-linear-to-br from-blue-600 to-indigo-600
                    flex items-center justify-center shadow-sm">

                    <i class="fas fa-graduation-cap text-white text-base"></i>

                </div>

                <!-- Icon vai trò -->
                <div
                    class="absolute -bottom-1 -right-1
                    w-4 h-4 rounded-full
                    bg-blue-500 border-2 border-white
                    flex items-center justify-center shadow-sm">

                    <i class="fas fa-user-graduate text-[8px] text-white"></i>

                </div>

            </div>

            <span
                class="text-xl font-bold
                 bg-linear-to-r from-blue-600 to-indigo-600
                 bg-clip-text text-transparent">

                GiaSu247

            </span>

        </a>

        <!-- Menu -->
        <nav class="hidden md:flex items-center space-x-1 font-medium text-gray-600">

            <a href="{{ route('student.home') }}"
                class="px-3 py-2 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-all duration-150 text-sm">
                <i class="fas fa-home mr-1 text-xs"></i> Trang chủ
            </a>

            <!-- Dropdown Quản lý lớp học -->
            <div class="relative group">
                <button
                    class="flex items-center gap-1 px-3 py-2 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-all duration-150 text-sm">
                    <i class="fas fa-book-open mr-1 text-xs"></i>
                    Quản lý lớp học
                    <i
                        class="fas fa-chevron-down text-xs ml-1 transition-transform duration-200 group-hover:rotate-180"></i>
                </button>

                <div class="absolute left-0 top-full pt-1 hidden group-hover:block">
                    <div class="bg-white border border-gray-100 shadow-xl rounded-xl w-52 p-1.5 z-50">
                        <a href="{{ route('classes.index') }}"
                            class="flex items-center gap-2 px-3 py-2.5 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition text-sm">
                            <i class="fas fa-history text-xs w-4 text-center text-gray-400"></i>
                            Lịch sử đăng lớp
                        </a>
                        <a href="{{ route('classes.index', ['status' => 'assigned']) }}"
                            class="flex items-center gap-2 px-3 py-2.5 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition text-sm">
                            <i class="fas fa-chalkboard-teacher text-xs w-4 text-center text-gray-400"></i>
                            Lớp học hiện hành
                        </a>
                    </div>
                </div>
            </div>

            <!-- Lời mời từ gia sư -->
            <a href="{{ route('student.applications.index') }}"
                class="relative px-3 py-2 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-all duration-150 text-sm">
                <i class="fas fa-envelope-open-text mr-1 text-xs"></i> Lời mời từ gia sư
                @if($pendingApplications > 0)
                    <span class="absolute -top-1 -right-1 inline-flex items-center justify-center min-w-[18px] h-[18px] px-1 rounded-full
                                 bg-red-500 text-white text-[10px] font-bold leading-none shadow-sm">
                        {{ $pendingApplications > 99 ? '99+' : $pendingApplications }}
                    </span>
                @endif
            </a>

            <!-- Nút đăng lớp nổi bật -->
            @auth
                @if (auth()->user()->role === 'student' || auth()->user()->role === 'both')
                    <a href="{{ route('create-class.step1') }}"
                        class="ml-2 bg-linear-to-r from-blue-600 to-indigo-600 text-white
                                                      px-5 py-2 rounded-xl font-semibold text-sm shadow-sm
                                                      hover:shadow-md hover:from-blue-700 hover:to-indigo-700
                                                      transition-all duration-200">
                        <i class="fas fa-plus mr-1"></i> Đăng lớp
                    </a>
                @endif
            @endauth

        </nav>

        <!-- Avatar / Login -->
        <div class="flex items-center gap-3">
            @auth
                <x-partials.user-dropdown />
            @else
                <a href="{{ route('login') }}"
                    class="bg-linear-to-r from-blue-600 to-indigo-600 text-white
                                      px-5 py-2 rounded-xl font-semibold text-sm shadow-sm
                                      hover:shadow-md hover:from-blue-700 hover:to-indigo-700
                                      transition-all duration-200">
                    Đăng nhập
                </a>
            @endauth
        </div>

    </div>
</header>
