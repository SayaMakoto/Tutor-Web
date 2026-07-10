@php
    $isTutor = Auth::user()->role === 'tutor';
    $layout = $isTutor ? 'layouts.tutor' : 'layouts.student';

    $theme = $isTutor
        ? [
            'text' => 'text-green-600',
            'gradFrom' => 'from-green-600',
            'gradTo' => 'to-indigo-600',
            'btnHoverFrom' => 'hover:from-green-700',
            'btnHoverTo' => 'hover:to-emerald-700',
        ]
        : [
            'text' => 'text-blue-600',
            'gradFrom' => 'from-blue-600',
            'gradTo' => 'to-indigo-600',
            'btnHoverFrom' => 'hover:from-blue-700',
            'btnHoverTo' => 'hover:to-indigo-700',
        ];
@endphp
@extends($layout)
@section('title', 'Thanh toán thành công')

@section('content')
    <div class="max-w-md mx-auto text-center py-8 space-y-6">

        {{-- Success Animation --}}
        <div class="relative">
            <div class="w-24 h-24 bg-linear-to-br from-emerald-400 to-teal-500 rounded-full
                    flex items-center justify-center mx-auto shadow-xl
                    animate-bounce"
                style="animation: successPop 0.5s ease-out forwards;">
                <i class="fas fa-check text-white text-4xl"></i>
            </div>
            {{-- Confetti dots --}}
            <div class="absolute top-0 left-1/4 w-3 h-3 bg-yellow-400 rounded-full animate-ping" style="animation-delay:0.2s">
            </div>
            <div class="absolute top-2 right-1/4 w-2 h-2 bg-blue-400 rounded-full animate-ping" style="animation-delay:0.4s">
            </div>
            <div class="absolute -top-2 left-1/2 w-2 h-2 bg-pink-400 rounded-full animate-ping" style="animation-delay:0.6s">
            </div>
        </div>

        <div>
            <h1 class="text-2xl font-bold text-gray-800">Thanh toán thành công!</h1>
            <p class="text-gray-500 text-sm mt-2">Giao dịch đã được xử lý thành công</p>
        </div>

        {{-- Summary Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-left space-y-3">
            <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                <span class="text-gray-600 text-sm">Mã giao dịch</span>
                <span class="font-mono text-sm font-semibold text-gray-800">{{ $order->order_ref ?? '—' }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-600 text-sm">Số tiền đã thanh toán</span>
                <span class="font-semibold text-gray-800">{{ number_format($order->amount_vnd ?? 0) }} VNĐ</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-600 text-sm">Thời gian</span>
                <span class="text-gray-800 text-sm">{{ now()->format('H:i — d/m/Y') }}</span>
            </div>
        </div>

        {{-- Actions --}}
        <div class="space-y-3">
            <a href="{{ route('payment.wallet') }}"
                class="block w-full bg-linear-to-r {{ $theme['gradFrom'] }} {{ $theme['gradTo'] }} text-white
                  py-3.5 rounded-xl font-bold hover:shadow-lg {{ $theme['btnHoverFrom'] }} {{ $theme['btnHoverTo'] }}
                  transition-all duration-200">
                <i class="fas fa-wallet mr-2"></i> Quay lại trang thanh toán
            </a>
        </div>

    </div>

    @push('scripts')
        <style>
            @keyframes successPop {
                0% {
                    transform: scale(0.5);
                    opacity: 0;
                }

                70% {
                    transform: scale(1.1);
                }

                100% {
                    transform: scale(1);
                    opacity: 1;
                }
            }
        </style>
    @endpush
@endsection
