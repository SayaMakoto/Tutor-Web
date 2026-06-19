<div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
    @php
        $missingCount = 0;
        if (Auth::check()) {
            if (is_null(Auth::user()->phone)) {
                $missingCount++;
            }
            if (is_null(Auth::user()->date_of_birth)) {
                $missingCount++;
            }
        }
    @endphp

    <div class="relative cursor-pointer">
        <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=0D8ABC&color=fff' }}"
            class="w-10 h-10 rounded-full border border-gray-200 shadow-sm object-cover hover:ring-2 hover:ring-blue-500 transition-all duration-150">
        
        @if($missingCount > 0)
            <!-- Badge on avatar, hidden when dropdown is hovered (open = true) -->
            <span x-show="!open" 
                  class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full text-[10px] w-5 h-5 flex items-center justify-center font-bold border-2 border-white shadow-md select-none">
                {{ $missingCount }}
            </span>
        @endif
    </div>

    <div x-show="open" x-transition.origin.top.right
        class="absolute right-0 top-full w-52 bg-white rounded-xl shadow-xl py-2 z-50 mt-1 border border-gray-100">

        <a href="{{ route('profile.edit') }}" class="flex items-center justify-between px-4 py-2 hover:bg-gray-50 text-gray-700 hover:text-blue-600 transition font-medium text-sm">
            <span class="flex items-center gap-2">
                <i class="fas fa-user-circle text-gray-400 text-sm"></i> Thông tin cá nhân
            </span>
            @if($missingCount > 0)
                <!-- Badge in dropdown menu item, visible when dropdown is hovered (open = true) -->
                <span class="bg-red-500 text-white rounded-full text-[10px] w-5 h-5 flex items-center justify-center font-bold shadow-sm select-none">
                    {{ $missingCount }}
                </span>
            @endif
        </a>

        <div class="border-t border-gray-100 my-1"></div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-left px-4 py-2 hover:bg-red-50 hover:text-red-600 text-red-500 transition font-medium text-sm flex items-center gap-2">
                <i class="fas fa-sign-out-alt text-xs"></i> Đăng xuất
            </button>
        </form>
    </div>
</div>
