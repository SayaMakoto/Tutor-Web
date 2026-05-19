<header class="bg-white shadow-md sticky top-0 z-50">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">

        <!-- Logo -->
        <a href="{{ route('tutor.home') }}" class="text-2xl font-bold text-green-600">
            GiaSu247 Tutor
        </a>

        <!-- Menu -->
        <nav class="hidden md:flex space-x-6 font-medium">

            <a href="{{ route('tutor.home') }}" class="hover:text-green-600">
                Dashboard
            </a>

            <div class="relative group">
                <button class="hover:text-blue-600 transition">
                    Quản lý lớp học
                </button>

                <div
                    class="absolute left-0 top-full hidden group-hover:block 
                bg-white shadow-lg rounded-xl w-56 p-2 z-50">
                    <a href="{{ route('tutor.classes.index') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-100">
                        Lớp đang tuyển
                    </a>

                    <a href="{{ route('tutor.classes.assigned') }}"
                        class="block px-4 py-2 rounded-lg hover:bg-gray-100">
                        Lớp đã ứng tuyển
                    </a>
                </div>
            </div>

            <a href="#" class="hover:text-green-600">
                Thu nhập
            </a>

        </nav>

        <!-- Right side -->
        <div>
            @auth
                <x-partials.user-dropdown />
            @else
                <a href="{{ route('login') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Đăng nhập
                </a>
            @endauth
        </div>

    </div>
</header>
