{{-- Hero Section thay thế Slider --}}
<div class="relative bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700 rounded-2xl mb-10 overflow-hidden">

    {{-- Decorative background shapes --}}
    <div class="absolute top-0 right-0 w-72 h-72 bg-white/5 rounded-full -translate-y-1/3 translate-x-1/4 pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-56 h-56 bg-white/5 rounded-full translate-y-1/3 -translate-x-1/4 pointer-events-none"></div>
    <div class="absolute top-1/2 right-16 w-4 h-4 bg-yellow-300/60 rounded-full pointer-events-none"></div>
    <div class="absolute top-10 left-24 w-2 h-2 bg-white/40 rounded-full pointer-events-none"></div>
    <div class="absolute bottom-12 right-36 w-3 h-3 bg-white/30 rounded-full pointer-events-none"></div>

    {{-- Content --}}
    <div class="relative z-10 px-8 md:px-16 py-14 md:py-20 text-white text-center">

        {{-- Badge --}}
        <div class="inline-flex items-center gap-2 bg-white/15 border border-white/20 
                    text-white text-sm font-medium px-4 py-1.5 rounded-full mb-6 backdrop-blur-sm">
            <i class="fas fa-star text-yellow-300 text-xs"></i>
            Nền tảng gia sư uy tín hàng đầu Việt Nam
        </div>

        {{-- Headline --}}
        <h1 class="text-3xl md:text-5xl font-extrabold mb-4 leading-tight tracking-tight">
            Kết nối gia sư uy tín
            <span class="block text-yellow-300 mt-1">— Học hiệu quả ngay hôm nay</span>
        </h1>

        {{-- Subtext --}}
        <p class="text-blue-100 text-base md:text-lg max-w-2xl mx-auto mb-8 leading-relaxed">
            Tìm đúng gia sư, đúng môn học, đúng khu vực.
            Nhanh chóng, minh bạch và hoàn toàn miễn phí cho học viên.
        </p>

        {{-- CTA Buttons --}}
        <div class="flex justify-center gap-3 flex-wrap">
            <a href="{{ route('classes.index') }}"
               class="inline-flex items-center gap-2 bg-white text-blue-600 
                      px-7 py-3 rounded-xl font-bold text-sm shadow-lg
                      hover:bg-blue-50 hover:shadow-xl hover:-translate-y-0.5 
                      transition-all duration-200">
                <i class="fas fa-search"></i>
                Tìm gia sư ngay
            </a>
            @guest
                <a href="{{ route('register.tutor') }}"
                   class="inline-flex items-center gap-2 border-2 border-white/60 text-white 
                          px-7 py-3 rounded-xl font-bold text-sm
                          hover:bg-white/10 hover:border-white hover:-translate-y-0.5
                          transition-all duration-200">
                    <i class="fas fa-chalkboard-teacher"></i>
                    Trở thành gia sư
                </a>
            @endguest
        </div>

        {{-- Stats Row --}}
        <div class="mt-12 pt-8 border-t border-white/20 grid grid-cols-3 gap-4 max-w-sm mx-auto text-center">
            <div>
                <p class="text-2xl font-bold text-white">500+</p>
                <p class="text-blue-200 text-xs mt-0.5">Gia sư</p>
            </div>
            <div class="border-x border-white/20">
                <p class="text-2xl font-bold text-white">1.000+</p>
                <p class="text-blue-200 text-xs mt-0.5">Lớp học</p>
            </div>
            <div>
                <p class="text-2xl font-bold text-yellow-300">4.8 ⭐</p>
                <p class="text-blue-200 text-xs mt-0.5">Đánh giá</p>
            </div>
        </div>

    </div>
</div>
