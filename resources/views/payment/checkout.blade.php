@php
    $isTutor = Auth::user()->role === 'tutor';
    $layout = $isTutor ? 'layouts.tutor' : 'layouts.student';
    $theme = $isTutor
        ? [
            'gradFrom' => 'from-green-600',
            'gradTo' => 'to-emerald-600',
            'text' => 'text-green-600',
            'border200' => 'border-green-200',
            'bg50' => 'bg-green-50',
            'hoverBg' => 'hover:bg-green-50/50',
            'iconBg' => 'bg-green-100',
            'iconColor' => 'text-green-600'
        ]
        : [
            'gradFrom' => 'from-blue-600',
            'gradTo' => 'to-indigo-600',
            'text' => 'text-blue-600',
            'border200' => 'border-blue-200',
            'bg50' => 'bg-blue-50',
            'hoverBg' => 'hover:bg-blue-50/50',
            'iconBg' => 'bg-blue-100',
            'iconColor' => 'text-blue-600'
        ];
@endphp

@extends($layout)
@section('title', 'Chọn phương thức thanh toán — ' . $order->order_ref)

@section('content')
    <div class="max-w-lg mx-auto space-y-6 pt-4">
        
        {{-- Header --}}
        <div class="text-center">
            <div class="w-14 h-14 bg-linear-to-br {{ $theme['gradFrom'] }} {{ $theme['gradTo'] }} rounded-2xl
                        flex items-center justify-center mx-auto mb-3 shadow-lg">
                <i class="fas fa-wallet text-white text-2xl"></i>
            </div>
            <h1 class="text-xl font-bold text-gray-800">Thanh toán đơn hàng</h1>
            <p class="text-sm text-gray-500 mt-1">Vui lòng chọn phương thức thanh toán bên dưới</p>
        </div>

        {{-- Order Summary --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 space-y-3 text-sm">
            <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                <span class="text-gray-500">Mã đơn hàng</span>
                <span class="font-mono font-semibold text-gray-800 bg-gray-50 px-2 py-1 rounded-md">{{ $order->order_ref }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-500 text-base">Tổng thanh toán</span>
                <span class="font-bold text-xl {{ $theme['text'] }}">{{ number_format($order->amount_vnd) }} VNĐ</span>
            </div>
        </div>

        {{-- Payment Methods --}}
        <div class="space-y-3">
            <h3 class="font-semibold text-gray-700 mb-3 px-1">Phương thức thanh toán</h3>
            
            {{-- QR Code --}}
            <a href="{{ route('payment.qr', $order->order_ref) }}" 
               class="flex items-center gap-4 bg-white p-4 rounded-xl border border-gray-200 {{ $theme['hoverBg'] }} transition group">
                <div class="w-12 h-12 {{ $theme['iconBg'] }} rounded-lg flex items-center justify-center shrink-0">
                    <i class="fas fa-qrcode text-xl {{ $theme['iconColor'] }}"></i>
                </div>
                <div class="flex-1">
                    <h4 class="font-semibold text-gray-800 group-hover:{{ $theme['text'] }} transition">Quét mã QR</h4>
                    <p class="text-xs text-gray-500 mt-0.5">Mở app ngân hàng hoặc ví điện tử để quét mã</p>
                </div>
                <i class="fas fa-chevron-right text-gray-300 group-hover:{{ $theme['text'] }} transition"></i>
            </a>

            {{-- ATM Nội địa --}}
            <a href="{{ route('payment.atm', $order->order_ref) }}" 
               class="flex items-center gap-4 bg-white p-4 rounded-xl border border-gray-200 {{ $theme['hoverBg'] }} transition group">
                <div class="w-12 h-12 {{ $theme['iconBg'] }} rounded-lg flex items-center justify-center shrink-0">
                    <i class="fas fa-credit-card text-xl {{ $theme['iconColor'] }}"></i>
                </div>
                <div class="flex-1">
                    <h4 class="font-semibold text-gray-800 group-hover:{{ $theme['text'] }} transition">Thẻ ATM nội địa</h4>
                    <p class="text-xs text-gray-500 mt-0.5">Thanh toán qua cổng VNPAY</p>
                </div>
                <i class="fas fa-chevron-right text-gray-300 group-hover:{{ $theme['text'] }} transition"></i>
            </a>

            {{-- Thẻ quốc tế --}}
            <a href="{{ route('payment.intl', $order->order_ref) }}" 
               class="flex items-center gap-4 bg-white p-4 rounded-xl border border-gray-200 {{ $theme['hoverBg'] }} transition group">
                <div class="w-12 h-12 {{ $theme['iconBg'] }} rounded-lg flex items-center justify-center shrink-0">
                    <i class="fab fa-cc-visa text-xl {{ $theme['iconColor'] }}"></i>
                </div>
                <div class="flex-1">
                    <h4 class="font-semibold text-gray-800 group-hover:{{ $theme['text'] }} transition">Thẻ quốc tế</h4>
                    <p class="text-xs text-gray-500 mt-0.5">Thanh toán bằng thẻ Visa, Mastercard, JCB</p>
                </div>
                <i class="fas fa-chevron-right text-gray-300 group-hover:{{ $theme['text'] }} transition"></i>
            </a>
        </div>

        {{-- Cancel Action --}}
        <div class="pt-4 text-center">
            <form action="{{ route('payment.cancel') }}" method="POST">
                @csrf
                <input type="hidden" name="order_ref" value="{{ $order->order_ref }}">
                <button type="submit" class="text-sm font-medium text-gray-500 hover:text-red-600 transition inline-flex items-center gap-1.5">
                    <i class="fas fa-arrow-left text-xs"></i>
                    Hủy và quay lại
                </button>
            </form>
        </div>

    </div>
@endsection
