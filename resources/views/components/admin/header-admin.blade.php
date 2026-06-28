<header class="h-14 bg-white border-b border-gray-200 px-6 flex items-center justify-between sticky top-0 z-40 shadow-sm">

    {{-- Logo + Brand --}}
    <a href="{{ route('admin.home') }}" class="flex items-center gap-2.5 group">
        <div class="w-8 h-8 bg-gradient-to-br from-violet-600 to-indigo-700 rounded-lg flex items-center justify-center shadow-sm group-hover:shadow-md transition">
            <i class="fas fa-graduation-cap text-white text-sm"></i>
        </div>
        <div class="leading-none">
            <span class="text-base font-bold bg-gradient-to-r from-violet-600 to-indigo-600 bg-clip-text text-transparent">GiaSu247</span>
            <span class="text-[10px] text-gray-400 block tracking-widest uppercase font-semibold">Admin Panel</span>
        </div>
    </a>

    {{-- Right side --}}
    <div class="flex items-center gap-4">

        {{-- Quick link trang người dùng --}}
        <a href="{{ route('student.home') }}" target="_blank"
           class="hidden md:flex items-center gap-1.5 text-xs text-gray-500 hover:text-violet-600 transition px-3 py-1.5 rounded-lg hover:bg-violet-50">
            <i class="fas fa-arrow-up-right-from-square text-xs"></i>
            Xem trang người dùng
        </a>

        {{-- Divider --}}
        <div class="w-px h-5 bg-gray-200"></div>

        {{-- User dropdown --}}
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="flex items-center gap-2.5 hover:opacity-80 transition">
                <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=7c3aed&color=fff' }}"
                     class="w-8 h-8 rounded-full object-cover border-2 border-violet-100" alt="avatar">
                <span class="hidden md:block text-sm font-semibold text-gray-700">{{ Auth::user()->name }}</span>
                <i class="fas fa-chevron-down text-xs text-gray-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
            </button>

            <div x-show="open" x-transition @click.outside="open = false"
                 class="absolute right-0 top-full mt-2 w-52 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50">
                <div class="px-4 py-2 border-b border-gray-100 mb-1">
                    <p class="text-xs font-semibold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</p>
                </div>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">
                        <i class="fas fa-right-from-bracket text-xs"></i> Đăng xuất
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
