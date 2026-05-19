<footer class="bg-gray-900 text-gray-300 mt-10">
    <div class="container mx-auto px-6 py-12 grid md:grid-cols-2 gap-10">

        <!-- Thông tin liên hệ -->
        <div>
            <h2 class="text-2xl font-bold text-white mb-6">
                Thông tin liên hệ
            </h2>

            <p class="mb-4">
                📧 Email: thuongmaya2006@gmail.com
            </p>

            <p class="mb-4">
                📞 Số điện thoại: 0785310575
            </p>

            <p class="mb-6">
                📍 Địa chỉ: Số 20 Tăng Nhơn Phú - Phường Phước Long - TP. Hồ Chí Minh
            </p>

            <!-- Nút chuyển sang trang liên hệ -->
            @auth
                <a href="{{ route('contact') }}"
                    class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition">
                    Gửi liên hệ →
                </a>
            @endauth
        </div>

        <!-- Giới thiệu ngắn -->
        <div>
            <h2 class="text-2xl font-bold text-white mb-6">
                Về GiaSu247
            </h2>

            <p class="text-gray-400 leading-relaxed">
                GiaSu247 là nền tảng kết nối học viên và gia sư uy tín,
                giúp việc tìm kiếm lớp học và gia sư trở nên nhanh chóng,
                minh bạch và hiệu quả.
            </p>
        </div>

    </div>

    <!-- Copyright -->
    <div class="border-t border-gray-700 text-center py-4 text-sm text-gray-400">
        © {{ date('Y') }} GiaSu247. All rights reserved.
    </div>
</footer>
