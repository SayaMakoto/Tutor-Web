<aside class="w-64 bg-white shadow-md sticky top-16 h-[calc(100vh-4rem)] p-6 hidden md:block">
    <h2 class="text-xl font-bold mb-6">Danh mục</h2>

    <ul class="space-y-4">

        <!-- Trang chủ -->
        <li>
            <a href="{{ route('student.home') }}" class="block hover:text-blue-600">
                Trang chủ
            </a>
        </li>

        <!-- Lịch sử đăng lớp  -->
        <li>
            <a href="{{ route('classes.index') }}" class="block hover:text-blue-600">
                Lịch sử đăng lớp
            </a>
        </li>

        <!-- Lớp học hiện hành  -->
        <li>
            <a href="{{ route('classes.index', ['status' => 'assigned']) }}" class="block hover:text-blue-600">
                Lớp học hiện hành
            </a>
        </li>

        <!-- Lời mời từ gia sư  -->
        <li>
            <a href="{{ route('student.applications.index') }}" class="block hover:text-blue-600">
                Lời mời từ gia sư
            </a>
        </li>

        <!-- Đăng lớp -->
        @auth
            <li>
                <a href="{{ route('create-class.step1') }}" class="block hover:text-blue-600">
                    Đăng lớp
                </a>
            </li>
        @endauth

        <li>
            <a href="{{ route('about') }}" class="block hover:text-blue-600">
                Giới thiệu
            </a>
        </li>

    </ul>
</aside>
