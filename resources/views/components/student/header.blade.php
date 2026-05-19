<header class="bg-white shadow-md sticky top-0 z-50">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">

        <!-- Logo -->
        <a href="{{ route('student.home') }}" class="text-2xl font-bold text-blue-600">
            GiaSu247
        </a>

        <!-- Menu -->
        <nav class="hidden md:flex items-center space-x-6 font-medium">

            <a href="{{ route('student.home') }}" class="hover:text-blue-600 transition">
                Trang chủ
            </a>

            <div class="relative group">
                <button class="hover:text-blue-600 transition">
                    Quản lý lớp học
                </button>

                <div
                    class="absolute left-0 top-full hidden group-hover:block 
                bg-white shadow-lg rounded-xl w-56 p-2 z-50">
                    <a href="{{ route('classes.index') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-100">
                        Lịch sử đăng lớp
                    </a>

                    <a href="{{ route('classes.index', ['status' => 'assigned']) }}"
                        class="block px-4 py-2 rounded-lg hover:bg-gray-100">
                        Lớp học hiện hành
                    </a>
                </div>
            </div>

            <!-- Lời mời từ gia sư -->
            <a href="{{ route('student.applications.index') }}" class="hover:text-blue-600 transition">
                Lời mời từ gia sư
            </a>

            <!-- Thanh toán -->
            <a href="#" class="hover:text-blue-600 transition">
                Thanh toán
            </a>

            <!-- Nút đăng lớp nổi bật -->
            @auth
                @if (auth()->user()->role === 'student' || auth()->user()->role === 'both')
                    <a href="{{ route('create-class.step1') }}"
                        class="border-2 border-blue-600 text-blue-600 px-4 py-2 rounded-xl font-semibold
                              hover:bg-blue-600 hover:text-white transition">
                        + Đăng lớp
                    </a>
                @endif
            @endauth

        </nav>

        <!-- Avatar / Login -->
        <div>
            @auth
                <x-partials.user-dropdown />
            @else
                <a href="{{ route('login') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    Đăng nhập
                </a>
            @endauth
        </div>

    </div>
</header>
