@extends($layout)

@section('title', 'Giới thiệu')

@section('content')

    <div class="max-w-6xl mx-auto px-6 py-12">

        {{-- Hero Section --}}
        <div class="text-center mb-16">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">
                Kết nối tri thức. Lan tỏa giá trị.
            </h1>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                Nền tảng thuê gia sư giúp học viên tìm đúng người hướng dẫn
                và giúp gia sư tìm đúng học viên một cách nhanh chóng, minh bạch và hiệu quả.
            </p>
        </div>

        {{-- 3 Core Values --}}
        <div class="grid md:grid-cols-3 gap-8 mb-20">

            <div class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition">
                <div class="text-indigo-600 text-3xl mb-4">🎯</div>
                <h3 class="font-semibold text-lg mb-2">Kết nối chính xác</h3>
                <p class="text-gray-600 text-sm">
                    Ghép nối học viên và gia sư dựa trên nhu cầu thực tế,
                    chuyên môn và khu vực, giảm thiểu thời gian tìm kiếm.
                </p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition">
                <div class="text-green-600 text-3xl mb-4">🔒</div>
                <h3 class="font-semibold text-lg mb-2">Minh bạch & an toàn</h3>
                <p class="text-gray-600 text-sm">
                    Thông tin được kiểm duyệt rõ ràng, quy trình xác thực giúp
                    cả hai bên yên tâm khi hợp tác.
                </p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition">
                <div class="text-yellow-500 text-3xl mb-4">🚀</div>
                <h3 class="font-semibold text-lg mb-2">Phát triển bền vững</h3>
                <p class="text-gray-600 text-sm">
                    Không chỉ là một lớp học, chúng tôi hướng đến sự tiến bộ lâu dài
                    và hành trình học tập hiệu quả.
                </p>
            </div>

        </div>

        {{-- For Students & Tutors --}}
        <div class="grid md:grid-cols-2 gap-10 mb-20">

            <div class="bg-indigo-50 p-8 rounded-2xl">
                <h2 class="text-2xl font-bold text-indigo-700 mb-4">
                    Dành cho Học viên
                </h2>
                <ul class="space-y-3 text-gray-700 text-sm">
                    <li>✔ Tìm gia sư theo môn học, khu vực, trình độ</li>
                    <li>✔ Đăng yêu cầu tìm lớp nhanh chóng</li>
                    <li>✔ Theo dõi đơn ứng tuyển minh bạch</li>
                    <li>✔ Tiết kiệm thời gian và chi phí</li>
                </ul>
            </div>

            <div class="bg-green-50 p-8 rounded-2xl">
                <h2 class="text-2xl font-bold text-green-700 mb-4">
                    Dành cho Gia sư
                </h2>
                <ul class="space-y-3 text-gray-700 text-sm">
                    <li>✔ Tìm lớp phù hợp với chuyên môn</li>
                    <li>✔ Quản lý hồ sơ và ứng tuyển dễ dàng</li>
                    <li>✔ Mở rộng cơ hội giảng dạy</li>
                    <li>✔ Xây dựng uy tín cá nhân</li>
                </ul>
            </div>

        </div>

        {{-- Mission Section --}}
        <div class="bg-white p-10 rounded-2xl shadow-sm text-center">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">
                Sứ mệnh của chúng tôi
            </h2>
            <p class="text-gray-600 max-w-3xl mx-auto">
                Chúng tôi tin rằng mỗi học viên đều xứng đáng có một người hướng dẫn phù hợp,
                và mỗi gia sư đều xứng đáng được công nhận giá trị chuyên môn của mình.
                Website này được xây dựng để thu hẹp khoảng cách đó.
            </p>
        </div>

    </div>

@endsection
