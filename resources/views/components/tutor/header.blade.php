<header class="bg-white border-b border-gray-100 shadow-sm sticky top-0 z-50">
    <div class="container mx-auto px-6 py-3 flex justify-between items-center">

        <!-- Logo -->
        <a href="{{ route('tutor.home') }}" class="flex items-center gap-2 group">

            <div class="relative">

                <!-- Logo chính -->
                <div
                    class="w-9 h-9 rounded-xl
                    bg-linear-to-br from-green-600 to-emerald-600
                    flex items-center justify-center shadow-sm">

                    <i class="fas fa-graduation-cap text-white text-base"></i>

                </div>

                <!-- Icon vai trò -->
                <div
                    class="absolute -bottom-1 -right-1
                    w-4 h-4 rounded-full
                    bg-green-500 border-2 border-white
                    flex items-center justify-center shadow-sm">

                    <i class="fas fa-chalkboard-teacher text-[8px] text-white"></i>

                </div>

            </div>

            <span
                class="text-xl font-bold
                 bg-linear-to-r from-green-600 to-emerald-600
                 bg-clip-text text-transparent">

                GiaSu247

            </span>

        </a>

        <!-- Menu -->
        <nav class="hidden md:flex items-center space-x-1 font-medium text-gray-600">

            <!-- Dashboard -->
            <a href="{{ route('tutor.home') }}"
                class="px-3 py-2 rounded-lg hover:bg-green-50 hover:text-green-600
                       transition-all duration-150 text-sm">

                <i class="fas fa-home mr-1 text-xs"></i>
                Dashboard
            </a>

            <!-- Dropdown quản lý lớp -->
            <div class="relative group">

                <button
                    class="flex items-center gap-1 px-3 py-2 rounded-lg
                           hover:bg-green-50 hover:text-green-600
                           transition-all duration-150 text-sm">

                    <i class="fas fa-book-open mr-1 text-xs"></i>

                    Quản lý lớp học

                    <i
                        class="fas fa-chevron-down text-xs ml-1 transition-transform duration-200 group-hover:rotate-180">
                    </i>
                </button>

                <div class="absolute left-0 top-full pt-1 hidden group-hover:block">

                    <div class="bg-white border border-gray-100 shadow-xl rounded-xl w-56 p-1.5 z-50">

                        <a href="{{ route('tutor.classes.index') }}"
                            class="flex items-center gap-2 px-3 py-2.5 rounded-lg
                                   hover:bg-green-50 hover:text-green-600
                                   transition text-sm">

                            <i class="fas fa-search text-xs w-4 text-center text-gray-400"></i>

                            Lớp đang tuyển
                        </a>

                        <a href="{{ route('tutor.classes.assigned') }}"
                            class="flex items-center gap-2 px-3 py-2.5 rounded-lg
                                   hover:bg-green-50 hover:text-green-600
                                   transition text-sm">

                            <i class="fas fa-paper-plane text-xs w-4 text-center text-gray-400"></i>

                            Lớp đã ứng tuyển
                        </a>

                    </div>

                </div>

            </div>

            <!-- Thu nhập -->
            <a href="#"
                class="px-3 py-2 rounded-lg hover:bg-green-50 hover:text-green-600
                       transition-all duration-150 text-sm">

                <i class="fas fa-wallet mr-1 text-xs"></i>

                Thu nhập
            </a>

            <!-- Thanh toán -->
            @auth
                <a href="{{ route('payment.wallet') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 text-sm font-medium
                          {{ request()->routeIs('payment.*')
                              ? 'bg-green-600 text-white shadow-sm'
                              : 'text-gray-600 hover:bg-green-50 hover:text-green-600' }}">
                    <i class="fas fa-coins w-4 text-center"></i>
                    <span class="flex-1">Ví Xu</span>
                    @php $xuBal = Auth::user()->wallet?->balance ?? 0; @endphp
                    <span
                        class="text-xs {{ request()->routeIs('payment.*') ? 'bg-white/20 text-white' : 'bg-green-100 text-green-700' }}
                                 font-semibold px-2 py-0.5 rounded-full">
                        {{ number_format($xuBal) }}
                    </span>
                </a>
            @endauth
        </nav>

        <!-- Right side -->
        <div class="flex items-center gap-3">

            @auth

                <x-partials.user-dropdown />
            @else
                <a href="{{ route('login') }}"
                    class="bg-linear-to-r from-green-600 to-emerald-600 text-white
                               px-5 py-2 rounded-xl font-semibold text-sm shadow-sm
                               hover:shadow-md hover:from-green-700 hover:to-emerald-700
                               transition-all duration-200">

                    Đăng nhập

                </a>

            @endauth

        </div>

    </div>
</header>
