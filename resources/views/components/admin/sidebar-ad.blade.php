<aside class="w-64 bg-white shadow-md p-6 hidden md:block">
    <h2 class="text-lg font-bold mb-6 text-gray-700">
        Quản trị
    </h2>

    <ul class="space-y-3">

        <!-- Dashboard -->
        <li>
            <a href="{{ route('admin.home') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-200">
                Dashboard
            </a>
        </li>

        <!-- QUẢN LÝ HỆ THỐNG -->
        <li>
            <button onclick="toggleAdminMenu()"
                class="w-full flex justify-between items-center px-3 py-2 rounded-lg hover:bg-gray-200">
                <span class="font-semibold text-gray-700">Quản lý hệ thống</span>
                <span id="adminArrow" class="transition-transform">▼</span>
            </button>

            <ul id="adminMenu" class="hidden mt-2 ml-4 space-y-2 border-l border-gray-200 pl-4">

                <li>
                    <a href="{{ route('admin.users.index') }}" class="block py-1 hover:text-blue-600">
                        Người dùng
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.students.index') }}" class="block py-1 hover:text-blue-600">
                        Học viên
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.tutors.index') }}" class="block py-1 hover:text-blue-600">
                        Gia sư
                    </a>
                </li>

            </ul>
        </li>

        <!-- QUẢN LÝ LỚP -->
        <li>
            <button onclick="toggleClassMenu()"
                class="w-full flex justify-between items-center px-3 py-2 rounded-lg hover:bg-gray-200">
                <span class="font-semibold text-gray-700">Quản lý lớp</span>
                <span id="classArrow" class="transition-transform">▼</span>
            </button>

            <ul id="classMenu" class="hidden mt-2 ml-4 space-y-2 border-l border-gray-200 pl-4">

                <li>
                    <a href="{{ route('admin.applications.index') }}" class="block py-1 hover:text-blue-600">
                        Đơn nhận lớp
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.class-requests.index') }}" class="block py-1 hover:text-blue-600">
                        Đơn đăng lớp
                    </a>
                </li>

            </ul>
        </li>

        <!-- DANH MỤC -->
        <li>
            <button onclick="toggleCategoryMenu()"
                class="w-full flex justify-between items-center px-3 py-2 rounded-lg hover:bg-gray-200">
                <span class="font-semibold text-gray-700">Danh mục</span>
                <span id="categoryArrow" class="transition-transform">▼</span>
            </button>

            <ul id="categoryMenu" class="hidden mt-2 ml-4 space-y-2 border-l border-gray-200 pl-4">

                <li>
                    <a href="{{ route('admin.grades.index') }}" class="block py-1 hover:text-blue-600">
                        Ngành học
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.subjects.index') }}" class="block py-1 hover:text-blue-600">
                        Môn học
                    </a>
                </li>

            </ul>
        </li>

        <!-- LIÊN HỆ -->
        <li>
            <a href="{{ route('admin.contacts.index') }}" class="block px-3 py-2 rounded-lg hover:bg-gray-200">
                Liên hệ
            </a>
        </li>

        <!-- TÀI CHÍNH -->
        <li>
            <a href="#" class="block px-3 py-2 rounded-lg hover:bg-gray-200">
                Thanh toán
            </a>
        </li>

        <!-- ĐÁNH GIÁ -->
        <li>
            <a href="#" class="block px-3 py-2 rounded-lg hover:bg-gray-200">
                Đánh giá
            </a>
        </li>

    </ul>
</aside>
