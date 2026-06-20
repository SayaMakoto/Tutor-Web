@php
    $isTutor = Auth::user()->role === 'tutor';
    $layout = $isTutor ? 'layouts.tutor' : 'layouts.student';

    $theme = $isTutor
        ? [
            'text' => 'text-green-500',
            'gradFrom' => 'from-green-600',
            'gradTo' => 'to-indigo-600',
        ]
        : [
            'text' => 'text-blue-500',
            'gradFrom' => 'from-blue-600',
            'gradTo' => 'to-indigo-600',
        ];
@endphp
@extends($layout)
@section('title', 'Thanh toán thất bại')

@section('content')
    <div class="max-w-md mx-auto text-center py-8 space-y-6">

        {{-- Failed Icon --}}
        <div
            class="w-24 h-24 bg-linear-to-br from-red-400 to-rose-600 rounded-full
                flex items-center justify-center mx-auto shadow-xl">
            <i class="fas fa-xmark text-white text-4xl"></i>
        </div>

        <div>
            <h1 class="text-2xl font-bold text-gray-800">Thanh toán thất bại</h1>
            <p class="text-gray-500 text-sm mt-2">
                {{ $reason ?? 'Giao dịch không thể hoàn tất. Vui lòng thử lại.' }}
            </p>
        </div>

        {{-- Info Card --}}
        <div class="bg-red-50 border border-red-100 rounded-2xl p-5 text-left">
            <div class="flex items-start gap-3">
                <i class="fas fa-circle-info text-red-500 mt-0.5 shrink-0"></i>
                <div class="text-sm text-red-700 space-y-1">
                    <p class="font-semibold">Nguyên nhân có thể:</p>
                    <ul class="space-y-0.5 text-red-600">
                        <li>• Hết thời gian thanh toán (quá 15 phút)</li>
                        <li>• Số dư tài khoản không đủ</li>
                        <li>• Người dùng hủy giao dịch</li>
                        <li>• Lỗi kết nối ngân hàng</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Order ref if available --}}
        @if (isset($order))
            <div class="bg-white border border-gray-100 rounded-xl p-4 text-sm text-left">
                <div class="flex justify-between text-gray-600">
                    <span>Mã đơn hàng</span>
                    <span class="font-mono font-semibold text-gray-800">{{ $order->order_ref }}</span>
                </div>
            </div>
        @endif

        {{-- Actions --}}
        <div class="space-y-3">
            <a href="{{ route('payment.topup') }}"
                class="block w-full bg-linear-to-r {{ $theme['gradFrom'] }} {{ $theme['gradTo'] }} text-white
                  py-3.5 rounded-xl font-bold hover:shadow-lg transition-all">
                <i class="fas fa-rotate-right mr-2"></i> Thử lại
            </a>
            <a href="{{ route('payment.wallet') }}"
                class="block w-full bg-white border border-gray-200 text-gray-700
                  py-3 rounded-xl font-semibold hover:bg-gray-50 transition text-sm">
                <i class="fas fa-wallet mr-2 {{ $theme['text'] }}"></i> Về trang ví
            </a>
        </div>

    </div>
@endsection
