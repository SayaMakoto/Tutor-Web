@extends($layout)
@section('title', 'Liên hệ')
@section('content')
    <div class="bg-white p-8 rounded-xl shadow">

        <h2 class="text-2xl font-bold text-center mb-8">
            Liên hệ với chúng tôi
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-16 gap-y-10">
            <!-- BÊN TRÁI -->
            <div>

                <h3 class="text-lg font-semibold mb-4">
                    Trung tâm Gia Sư 247
                </h3>

                <p class="text-gray-600 mb-4">
                    Chúng tôi cung cấp dịch vụ gia sư chất lượng cao với đội ngũ giảng viên và sinh viên xuất sắc từ các
                    trường đại học hàng đầu.
                </p>

                <div class="space-y-2 text-gray-700 mb-6">
                    <p>📍 Địa chỉ: Số 20 Tăng Nhơn Phú - Phường Phước Long - TP. Hồ Chí Minh</p>
                    <p>📞 Điện thoại: 0909 123 456</p>
                    <p>📧 Email: contact@giasu247.vn</p>
                    <p>⏰ Giờ làm việc: 08:00 - 21:00</p>
                </div>

                <!-- Google map -->
                <div class="rounded-xl overflow-hidden shadow">
                    <iframe
                        src="https://www.google.com/maps?q=Số 20 Tăng Nhơn Phú - Phường Phước Long - TP. Hồ Chí Minh&output=embed"
                        class="w-full h-64 border-0">
                    </iframe>
                </div>

            </div>


            <!-- BÊN PHẢI -->
            <div class="min-w-0">

                <form action="{{ route('contact.store') }}" method="POST" class="space-y-4">
                    @csrf

                    @php
                        $user = auth()->user();
                    @endphp

                    <div>
                        <label class="block mb-1">Họ và tên</label>
                        <input type="text" class="w-full border rounded-lg p-2 bg-gray-100" name="name"
                            value="{{ $user->name }}" readonly>
                    </div>

                    <div>
                        <label class="block mb-1">Email</label>
                        <input type="email" class="w-full border rounded-lg p-2 bg-gray-100" name="email"
                            value="{{ $user->email }}" readonly>
                    </div>

                    <div>
                        <label class="block mb-1">Số điện thoại</label>
                        <input type="text" class="w-full border rounded-lg p-2 bg-gray-100" name="phone"
                            value="{{ $user->phone }}" readonly>
                    </div>

                    <div>
                        <label class="block mb-1">Nội dung</label>
                        <textarea rows="5" class="w-full border rounded-lg p-2" name="message" required></textarea>
                    </div>

                    <button class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                        Gửi liên hệ
                    </button>

                </form>

            </div>

        </div>
    </div>
@endsection
