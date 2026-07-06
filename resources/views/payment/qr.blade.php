@php
    // Xác định role hiện tại để chọn layout & màu chủ thể phù hợp
    $isTutor = Auth::user()->role === 'tutor';
    $layout = $isTutor ? 'layouts.tutor' : 'layouts.student';

    $theme = $isTutor
        ? [
            'gradFrom' => 'from-green-600',
            'gradTo' => 'to-emerald-600',
            'text' => 'text-green-600',
            'text700' => 'text-green-700',
            'bg50' => 'bg-green-50',
            'bg100' => 'bg-green-100',
            'border' => 'border-green-600',
            'border200' => 'border-green-200',
            'btnHoverFrom' => 'hover:from-green-700',
            'btnHoverTo' => 'hover:to-emerald-700',
            'qrDark' => '#15803d',
        ]
        : [
            'gradFrom' => 'from-blue-600',
            'gradTo' => 'to-indigo-600',
            'text' => 'text-blue-600',
            'text700' => 'text-blue-700',
            'bg50' => 'bg-blue-50',
            'bg100' => 'bg-blue-100',
            'border' => 'border-blue-600',
            'border200' => 'border-blue-200',
            'btnHoverFrom' => 'hover:from-blue-700',
            'btnHoverTo' => 'hover:to-indigo-700',
            'qrDark' => '#1d4ed8',
        ];
@endphp
@extends($layout)
@section('title', 'Thanh toán QR — ' . $order->order_ref)

@section('content')
    <div class="max-w-lg mx-auto space-y-5">

        {{-- Header --}}
        <div class="text-center">
            <div
                class="w-14 h-14 bg-linear-to-br {{ $theme['gradFrom'] }} {{ $theme['gradTo'] }} rounded-2xl
                    flex items-center justify-center mx-auto mb-3 shadow-lg">
                <i class="fas fa-qrcode text-white text-2xl"></i>
            </div>
            <h1 class="text-xl font-bold text-gray-800">Quét mã QR để thanh toán</h1>
            <p class="text-sm text-gray-500 mt-1">Dùng app ngân hàng hoặc ví điện tử để quét</p>
        </div>

        {{-- QR Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center">

            {{-- Countdown --}}
            <div class="flex items-center justify-center gap-2 mb-4">
                <i class="fas fa-clock text-amber-500 text-sm"></i>
                <span class="text-sm text-gray-600">Hết hạn sau: </span>
                <span id="countdown" class="font-bold text-amber-600 text-lg font-mono">14:59</span>
            </div>

            {{-- QR Code Container --}}
            <div class="flex justify-center mb-4">
                <div class="relative p-3 border-4 {{ $theme['border'] }} rounded-2xl bg-white shadow-inner">
                    {{-- QR tạo bởi JS --}}
                    <div id="qrcode" class="w-52 h-52"></div>
                    {{-- Overlay logo giữa QR --}}
                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                        <div
                            class="w-10 h-10 {{ $theme['gradFrom'] === 'from-green-600' ? 'bg-green-600' : 'bg-blue-600' }} rounded-lg flex items-center justify-center shadow-md">
                            <i class="fas fa-graduation-cap text-white text-sm"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- VNPAY Logo + Bank list --}}
            <div class="flex items-center justify-center gap-2 mb-4">
                <div class="text-xs text-gray-400">Hỗ trợ</div>
                <div class="flex gap-1.5">
                    @foreach (['Vietcombank', 'Techcombank', 'MBBank', 'Momo', 'ZaloPay'] as $bank)
                        <span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full">{{ $bank }}</span>
                    @endforeach
                </div>
            </div>

            <div class="border-t border-gray-100 pt-4 space-y-2 text-sm">
                <div class="flex justify-between text-gray-600">
                    <span>Mã đơn hàng</span>
                    <span class="font-mono font-semibold text-gray-800">{{ $order->order_ref }}</span>
                </div>
                <div class="flex justify-between text-gray-600">
                    <span>Số Xu nhận</span>
                    <span class="font-bold {{ $theme['text'] }}">{{ number_format($order->coin_amount) }} Xu</span>
                </div>
                <div class="flex justify-between text-gray-600">
                    <span>Số tiền</span>
                    <span class="font-bold text-gray-800 text-base">{{ number_format($order->amount_vnd) }} VNĐ</span>
                </div>
            </div>
        </div>

        {{-- Sandbox Notice --}}
        <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 flex items-start gap-3">
            <i class="fas fa-triangle-exclamation text-amber-500 mt-0.5 shrink-0"></i>
            <div>
                <p class="font-semibold text-amber-800 text-sm">Môi trường Sandbox</p>
                <p class="text-amber-700 text-xs mt-0.5">
                    Đây là môi trường thử nghiệm. Nhấn <strong>"Mô phỏng thanh toán"</strong> để giả lập giao dịch thành
                    công.
                </p>
            </div>
        </div>

        {{-- Actions --}}
        <div class="space-y-3">
            {{-- Simulate payment (Sandbox only) --}}
            <form action="{{ route('payment.simulate') }}" method="POST">
                @csrf
                <input type="hidden" name="order_ref" value="{{ $order->order_ref }}">
                <button type="submit"
                    class="w-full bg-linear-to-r from-emerald-600 to-teal-600 text-white
                           py-4 rounded-xl font-bold shadow-sm hover:shadow-md
                           hover:from-emerald-700 hover:to-teal-700 transition-all
                           flex items-center justify-center gap-2">
                    <i class="fas fa-check-circle"></i>
                    Mô phỏng thanh toán thành công (Sandbox)
                </button>
            </form>

            {{-- Simulate failed payment --}}
            <form action="{{ route('payment.simulate.fail') }}" method="POST">
                @csrf
                <input type="hidden" name="order_ref" value="{{ $order->order_ref }}">
                <button type="submit"
                    class="w-full bg-white border-2 border-red-200 text-red-600
                           py-3 rounded-xl font-semibold text-sm hover:bg-red-50 transition
                           flex items-center justify-center gap-2">
                    <i class="fas fa-xmark-circle"></i>
                    Mô phỏng thanh toán thất bại (Sandbox)
                </button>
            </form>

            {{-- Check status --}}
            <button onclick="checkStatus()"
                class="w-full bg-white border-2 {{ $theme['border200'] }} {{ $theme['text'] }}
                       py-3 rounded-xl font-semibold text-sm hover:{{ $theme['bg50'] }} transition
                       flex items-center justify-center gap-2">
                <i class="fas fa-arrows-rotate" id="refreshIcon"></i>
                Kiểm tra trạng thái thanh toán
            </button>

            {{-- Cancel --}}
            <form action="{{ route('payment.cancel') }}" method="POST">
                @csrf
                <input type="hidden" name="order_ref" value="{{ $order->order_ref }}">
                <button type="submit" class="w-full text-gray-500 py-2 text-sm hover:text-red-600 transition">
                    Hủy đơn và quay lại
                </button>
            </form>
        </div>

    </div>
@endsection

@push('scripts')
    {{-- QR Code library --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        // Màu QR theo theme — lấy 1 lần ra biến JS, tránh nhúng Blade lặp lại bên trong logic
        const qrColorDark = "{{ $theme['qrDark'] }}";

        // Tạo QR code
        const qrData = "GiaSu247|{{ $order->order_ref }}|{{ $order->amount_vnd }}|{{ $order->coin_amount }}";
        new QRCode(document.getElementById("qrcode"), {
            text: qrData,
            width: 208,
            height: 208,
            colorDark: qrColorDark,
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.M
        });

        // Countdown timer
        const expiresAt = new Date("{{ $order->expires_at?->toISOString() ?? now()->addMinutes(15)->toISOString() }}");
        const countdownEl = document.getElementById('countdown');

        const timer = setInterval(() => {
            const now = new Date();
            const diff = Math.max(0, Math.floor((expiresAt - now) / 1000));
            if (diff <= 0) {
                clearInterval(timer);
                countdownEl.textContent = 'Hết hạn';
                countdownEl.classList.replace('text-amber-600', 'text-red-600');
                return;
            }
            const m = String(Math.floor(diff / 60)).padStart(2, '0');
            const s = String(diff % 60).padStart(2, '0');
            countdownEl.textContent = `${m}:${s}`;
        }, 1000);

        // Check payment status
        function checkStatus() {
            const icon = document.getElementById('refreshIcon');
            icon.classList.add('animate-spin');
            fetch("{{ route('payment.status', $order->order_ref) }}")
                .then(r => r.json())
                .then(data => {
                    icon.classList.remove('animate-spin');
                    if (data.status === 'success') {
                        window.location.href = "{{ route('payment.success') }}?ref={{ $order->order_ref }}";
                    }
                })
                .catch(() => icon.classList.remove('animate-spin'));
        }

        // Auto check every 10s
        setInterval(checkStatus, 10000);
    </script>
@endpush
