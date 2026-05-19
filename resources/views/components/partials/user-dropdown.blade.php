<div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">

    <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://i.pravatar.cc/40' }}"
        class="w-10 h-10 rounded-full border cursor-pointer object-cover">

    <div x-show="open" x-transition.origin.top.right
        class="absolute right-0 top-full w-48 bg-white rounded-xl shadow-xl py-2 z-50">

        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-gray-100">
            Thông tin cá nhân
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100 text-red-500">
                Đăng xuất
            </button>
        </form>
    </div>
</div>
