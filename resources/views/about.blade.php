@extends($layout)
@section('title', 'Giới thiệu về GiaSu247')

@section('content')

    {{-- Hero Section --}}
    <div class="relative bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700
                rounded-2xl overflow-hidden text-white text-center px-8 py-16 mb-10">
        <div class="absolute top-0 left-0 w-48 h-48 bg-white/5 rounded-full -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-64 h-64 bg-white/5 rounded-full translate-x-1/3 translate-y-1/3"></div>

        <div class="relative z-10">
            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg">
                <i class="fas fa-graduation-cap text-white text-3xl"></i>
            </div>
            <h1 class="text-4xl font-bold mb-4">Kết nối tri thức. Lan tỏa giá trị.</h1>
            <p class="text-blue-100 text-lg max-w-2xl mx-auto leading-relaxed">
                Nền tảng kết nối học viên và gia sư uy tín, giúp việc tìm kiếm lớp học
                trở nên nhanh chóng, minh bạch và hiệu quả.
            </p>

            <div class="flex justify-center gap-6 mt-8">
                <div class="text-center">
                    <p class="text-3xl font-bold">500+</p>
                    <p class="text-blue-200 text-sm">Gia sư</p>
                </div>
                <div class="w-px bg-white/20"></div>
                <div class="text-center">
                    <p class="text-3xl font-bold">2,000+</p>
                    <p class="text-blue-200 text-sm">Học viên</p>
                </div>
                <div class="w-px bg-white/20"></div>
                <div class="text-center">
                    <p class="text-3xl font-bold">4.9<i class="fas fa-star text-yellow-400 text-xl ml-1"></i></p>
                    <p class="text-blue-200 text-sm">Đánh giá</p>
                </div>
            </div>
        </div>
    </div>

    {{-- 3 Core Values --}}
    <div class="grid md:grid-cols-3 gap-5 mb-10">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all hover:-translate-y-0.5">
            <div class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center mb-4">
                <i class="fas fa-bullseye text-indigo-600 text-xl"></i>
            </div>
            <h3 class="font-bold text-gray-800 mb-2">Kết nối chính xác</h3>
            <p class="text-gray-500 text-sm leading-relaxed">
                Ghép nối học viên và gia sư dựa trên nhu cầu thực tế,
                chuyên môn và khu vực, giảm thiểu thời gian tìm kiếm.
            </p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all hover:-translate-y-0.5">
            <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center mb-4">
                <i class="fas fa-shield-halved text-emerald-600 text-xl"></i>
            </div>
            <h3 class="font-bold text-gray-800 mb-2">Minh bạch & an toàn</h3>
            <p class="text-gray-500 text-sm leading-relaxed">
                Thông tin được kiểm duyệt rõ ràng, quy trình xác thực giúp
                cả hai bên yên tâm khi hợp tác.
            </p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all hover:-translate-y-0.5">
            <div class="w-12 h-12 bg-amber-50 rounded-2xl flex items-center justify-center mb-4">
                <i class="fas fa-rocket text-amber-600 text-xl"></i>
            </div>
            <h3 class="font-bold text-gray-800 mb-2">Phát triển bền vững</h3>
            <p class="text-gray-500 text-sm leading-relaxed">
                Không chỉ là một lớp học, chúng tôi hướng đến sự tiến bộ lâu dài
                và hành trình học tập hiệu quả.
            </p>
        </div>
    </div>

    {{-- For Students & Tutors --}}
    <div class="grid md:grid-cols-2 gap-6 mb-10">
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-100 p-8 rounded-2xl">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-user-graduate text-white"></i>
                </div>
                <h2 class="text-xl font-bold text-blue-800">Dành cho Học viên</h2>
            </div>
            <ul class="space-y-3 text-gray-700 text-sm">
                @foreach(['Tìm gia sư theo môn học, khu vực, trình độ', 'Đăng yêu cầu tìm lớp nhanh chóng', 'Theo dõi đơn ứng tuyển minh bạch', 'Tiết kiệm thời gian và chi phí'] as $item)
                    <li class="flex items-center gap-2">
                        <i class="fas fa-check-circle text-blue-500 flex-shrink-0"></i> {{ $item }}
                    </li>
                @endforeach
            </ul>
            <a href="{{ route('classes.index') }}"
               class="mt-5 inline-flex items-center gap-2 bg-blue-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-blue-700 transition">
                <i class="fas fa-search"></i> Tìm gia sư ngay
            </a>
        </div>

        <div class="bg-gradient-to-br from-emerald-50 to-teal-50 border border-emerald-100 p-8 rounded-2xl">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 bg-emerald-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-chalkboard-teacher text-white"></i>
                </div>
                <h2 class="text-xl font-bold text-emerald-800">Dành cho Gia sư</h2>
            </div>
            <ul class="space-y-3 text-gray-700 text-sm">
                @foreach(['Tìm lớp phù hợp với chuyên môn', 'Quản lý hồ sơ và ứng tuyển dễ dàng', 'Mở rộng cơ hội giảng dạy', 'Xây dựng uy tín cá nhân'] as $item)
                    <li class="flex items-center gap-2">
                        <i class="fas fa-check-circle text-emerald-500 flex-shrink-0"></i> {{ $item }}
                    </li>
                @endforeach
            </ul>
            <a href="{{ route('register.tutor') }}"
               class="mt-5 inline-flex items-center gap-2 bg-emerald-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-emerald-700 transition">
                <i class="fas fa-user-plus"></i> Đăng ký làm Gia sư
            </a>
        </div>
    </div>

    {{-- Mission Section --}}
    <div class="bg-white p-10 rounded-2xl shadow-sm border border-gray-100 text-center">
        <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-heart text-blue-600 text-xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Sứ mệnh của chúng tôi</h2>
        <p class="text-gray-500 max-w-2xl mx-auto leading-relaxed">
            Chúng tôi tin rằng mỗi học viên đều xứng đáng có một người hướng dẫn phù hợp,
            và mỗi gia sư đều xứng đáng được công nhận giá trị chuyên môn của mình.
            GiaSu247 được xây dựng để thu hẹp khoảng cách đó.
        </p>
        <div class="flex justify-center gap-3 mt-6">
            <a href="{{ route('student.home') }}"
               class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600
                      text-white px-6 py-3 rounded-xl font-semibold hover:shadow-lg hover:from-blue-700 hover:to-indigo-700 transition-all">
                <i class="fas fa-arrow-right"></i> Bắt đầu ngay
            </a>
        </div>
    </div>

@endsection
