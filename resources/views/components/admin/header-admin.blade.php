<header class="bg-gray-900 text-white px-6 py-4 flex justify-between items-center shadow-md">
    <a href="{{ route('admin.home') }}">
        <h1 class="text-xl font-bold">Admin Panel</h1>
    </a>

    <div class="flex items-center space-x-4">
        <span>Xin chào, {{ auth()->user()->name }}</span>

        <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">

            <!-- Avatar -->
            <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://i.pravatar.cc/40' }}"
                class="w-8 h-8 rounded-full cursor-pointer object-cover border border-gray-600">

            <!-- Dropdown -->
            <div x-show="open" x-transition.origin.top.right
                class="absolute right-0 top-full w-48 bg-white text-gray-700 rounded-xl shadow-xl py-2 z-50">

                <!-- Logout -->
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 text-red-500 hover:bg-gray-100 w-full text-left">
                        Đăng xuất
                    </button>
                </form>

            </div>
        </div>
    </div>
</header>
