<footer class="bg-gray-900 text-gray-300 mt-10">

    {{-- Wave top --}}
    <div class="w-full overflow-hidden leading-none">
        <svg viewBox="0 0 1200 50" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"
             class="w-full h-8 fill-gray-50">
            <path d="M0,50 C300,0 900,50 1200,10 L1200,0 L0,0 Z" />
        </svg>
    </div>

    <div class="container mx-auto px-6 py-10 grid md:grid-cols-3 gap-10">

        {{-- Cột 1: Brand --}}
        <div>
            <a href="{{ route('student.home') }}" class="flex items-center gap-2 mb-4">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center">
                    <i class="fas fa-graduation-cap text-white text-sm"></i>
                </div>
                <span class="text-xl font-bold text-white">GiaSu247</span>
            </a>
            <p class="text-gray-400 text-sm leading-relaxed mb-5">
                Nền tảng kết nối học viên và gia sư uy tín, giúp việc tìm kiếm lớp học
                trở nên nhanh chóng, minh bạch và hiệu quả.
            </p>
            {{-- Social --}}
            <div class="flex items-center gap-3">
                <a href="#" class="w-9 h-9 bg-gray-800 hover:bg-blue-600 rounded-lg flex items-center justify-center transition-colors duration-150">
                    <i class="fab fa-facebook-f text-sm"></i>
                </a>
                <a href="#" class="w-9 h-9 bg-gray-800 hover:bg-green-600 rounded-lg flex items-center justify-center transition-colors duration-150">
                    <i class="fas fa-comment-dots text-sm"></i>
                </a>
                <a href="#" class="w-9 h-9 bg-gray-800 hover:bg-red-600 rounded-lg flex items-center justify-center transition-colors duration-150">
                    <i class="fab fa-youtube text-sm"></i>
                </a>
            </div>
        </div>

        {{-- Cột 2: Liên kết nhanh --}}
        <div>
            <h3 class="text-white font-semibold mb-4 flex items-center gap-2">
                <i class="fas fa-link text-blue-400 text-xs"></i> Liên kết nhanh
            </h3>
            <ul class="space-y-2.5">
                <li>
                    <a href="{{ route('student.home') }}"
                       class="text-sm text-gray-400 hover:text-white hover:translate-x-1 transition-all duration-150 flex items-center gap-2">
                        <i class="fas fa-chevron-right text-blue-500 text-xs"></i> Trang chủ
                    </a>
                </li>
                <li>
                    <a href="{{ route('classes.index') }}"
                       class="text-sm text-gray-400 hover:text-white hover:translate-x-1 transition-all duration-150 flex items-center gap-2">
                        <i class="fas fa-chevron-right text-blue-500 text-xs"></i> Tìm gia sư
                    </a>
                </li>
                <li>
                    <a href="{{ route('about') }}"
                       class="text-sm text-gray-400 hover:text-white hover:translate-x-1 transition-all duration-150 flex items-center gap-2">
                        <i class="fas fa-chevron-right text-blue-500 text-xs"></i> Giới thiệu
                    </a>
                </li>
                @auth
                    <li>
                        <a href="{{ route('create-class.step1') }}"
                           class="text-sm text-gray-400 hover:text-white hover:translate-x-1 transition-all duration-150 flex items-center gap-2">
                            <i class="fas fa-chevron-right text-blue-500 text-xs"></i> Đăng lớp
                        </a>
                    </li>
                @endauth
                <li>
                    <a href="{{ route('register.tutor') }}"
                       class="text-sm text-gray-400 hover:text-white hover:translate-x-1 transition-all duration-150 flex items-center gap-2">
                        <i class="fas fa-chevron-right text-blue-500 text-xs"></i> Trở thành gia sư
                    </a>
                </li>
            </ul>
        </div>

        {{-- Cột 3: Thông tin liên hệ --}}
        <div>
            <h3 class="text-white font-semibold mb-4 flex items-center gap-2">
                <i class="fas fa-headset text-blue-400 text-xs"></i> Liên hệ với chúng tôi
            </h3>
            <ul class="space-y-3">
                <li class="flex items-start gap-3 text-sm text-gray-400">
                    <i class="fas fa-envelope text-blue-400 mt-0.5 w-4 text-center flex-shrink-0"></i>
                    <span>thuongmaya2006@gmail.com</span>
                </li>
                <li class="flex items-start gap-3 text-sm text-gray-400">
                    <i class="fas fa-phone-alt text-blue-400 mt-0.5 w-4 text-center flex-shrink-0"></i>
                    <span>0785 310 575</span>
                </li>
                <li class="flex items-start gap-3 text-sm text-gray-400">
                    <i class="fas fa-map-marker-alt text-blue-400 mt-0.5 w-4 text-center flex-shrink-0"></i>
                    <span>Số 20 Tăng Nhơn Phú, Phường Phước Long, TP. Hồ Chí Minh</span>
                </li>
            </ul>

            @auth
                <a href="{{ route('contact') }}"
                   class="mt-5 inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 
                          text-white text-sm px-5 py-2.5 rounded-xl transition font-medium">
                    <i class="fas fa-paper-plane"></i> Gửi liên hệ
                </a>
            @endauth
        </div>

    </div>

    {{-- Copyright --}}
    <div class="border-t border-gray-800 text-center py-4 text-xs text-gray-500">
        © {{ date('Y') }} GiaSu247. All rights reserved. — Được xây dựng với
        <i class="fas fa-heart text-red-500 mx-0.5"></i> tại Việt Nam
    </div>

</footer>
