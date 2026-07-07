@php
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
        ];
@endphp
@extends($layout)
@section('title', 'Thanh toán thẻ quốc tế — ' . $order->order_ref)

@section('content')
    <div class="max-w-lg mx-auto space-y-5">

        {{-- Header --}}
        <div class="text-center">
            <div
                class="w-14 h-14 bg-linear-to-br {{ $theme['gradFrom'] }} {{ $theme['gradTo'] }} rounded-2xl
                    flex items-center justify-center mx-auto mb-3 shadow-lg">
                <i class="fab fa-cc-visa text-white text-2xl"></i>
            </div>
            <h1 class="text-xl font-bold text-gray-800">Thanh toán qua thẻ quốc tế</h1>
            <p class="text-sm text-gray-500 mt-1">Hỗ trợ Visa, Mastercard và JCB</p>
        </div>

        {{-- Card Logos --}}
        <div class="flex items-center justify-center gap-4">
            <div class="flex items-center gap-1.5 bg-white border border-gray-200 rounded-xl px-3 py-2 shadow-sm">
                <i class="fab fa-cc-visa text-blue-700 text-2xl"></i>
                <i class="fab fa-cc-mastercard text-red-500 text-2xl"></i>
                <i class="fab fa-cc-jcb text-green-600 text-2xl"></i>
            </div>
        </div>

        {{-- Countdown --}}
        <div class="flex items-center justify-center gap-2">
            <i class="fas fa-clock text-amber-500 text-sm"></i>
            <span class="text-sm text-gray-600">Hết hạn sau: </span>
            <span id="countdown" class="font-bold text-amber-600 text-lg font-mono">14:59</span>
        </div>

        {{-- Visual Card Preview --}}
        <div class="relative mx-auto w-full max-w-sm">
            <div class="bg-linear-to-br from-gray-800 via-gray-900 to-gray-950 rounded-2xl p-6 text-white shadow-xl
                        aspect-[1.6/1] flex flex-col justify-between">
                {{-- Top row --}}
                <div class="flex justify-between items-start">
                    <div class="w-10 h-7 bg-amber-400/80 rounded-md"></div>
                    <i class="fab fa-cc-visa text-white/60 text-3xl" id="cardBrandIcon"></i>
                </div>
                {{-- Card number --}}
                <div>
                    <p class="text-lg font-mono tracking-[0.2em] text-white/90" id="previewNumber">
                        •••• •••• •••• ••••
                    </p>
                </div>
                {{-- Bottom row --}}
                <div class="flex justify-between items-end">
                    <div>
                        <p class="text-[10px] text-white/40 uppercase">Chủ thẻ</p>
                        <p class="text-sm font-semibold tracking-wide text-white/80" id="previewName">YOUR NAME</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] text-white/40 uppercase">Hết hạn</p>
                        <p class="text-sm font-mono text-white/80" id="previewExpiry">MM/YY</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Credit Card Form --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2 text-sm">
                <i class="fas fa-lock {{ $theme['text'] }} text-sm"></i> Thông tin thẻ
            </h3>

            <div class="space-y-4">
                {{-- Số thẻ --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Số thẻ</label>
                    <div class="relative">
                        <i class="fas fa-credit-card absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                        <input type="text" id="cardNumber" placeholder="4111 1111 1111 1111" maxlength="19"
                            oninput="onCardNumberInput(this)"
                            class="w-full pl-9 pr-4 py-3 border border-gray-200 rounded-xl text-sm font-mono tracking-wider
                                   focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:outline-none">
                    </div>
                </div>

                {{-- Tên trên thẻ --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Tên trên thẻ</label>
                    <div class="relative">
                        <i class="fas fa-user absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                        <input type="text" id="cardName" placeholder="NGUYEN VAN A" style="text-transform: uppercase"
                            oninput="updatePreview()"
                            class="w-full pl-9 pr-4 py-3 border border-gray-200 rounded-xl text-sm tracking-wide
                                   focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:outline-none">
                    </div>
                </div>

                {{-- Ngày hết hạn + CVV --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Hết hạn</label>
                        <div class="relative">
                            <i class="fas fa-calendar absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                            <input type="text" id="cardExpiry" placeholder="MM/YY" maxlength="5"
                                oninput="onExpiryInput(this)"
                                class="w-full pl-9 pr-4 py-3 border border-gray-200 rounded-xl text-sm font-mono
                                       focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:outline-none">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">CVV</label>
                        <div class="relative">
                            <i class="fas fa-shield-halved absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                            <input type="password" placeholder="•••" maxlength="3"
                                class="w-full pl-9 pr-4 py-3 border border-gray-200 rounded-xl text-sm font-mono
                                       focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:outline-none">
                        </div>
                    </div>
                </div>
            </div>

            <p class="text-xs text-gray-400 mt-4 flex items-center gap-1.5">
                <i class="fas fa-shield-halved text-gray-300"></i>
                Thông tin thẻ không được lưu trữ — Môi trường thử nghiệm
            </p>
        </div>

        {{-- Order Summary --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-bold text-gray-800 mb-3 text-sm">Tóm tắt đơn hàng</h3>
            <div class="space-y-2 text-sm">
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
                    Đây là môi trường thử nghiệm. Nhấn <strong>"Mô phỏng thanh toán"</strong> để giả lập giao dịch thành công.
                </p>
            </div>
        </div>

        {{-- Actions --}}
        <div class="space-y-3">
            {{-- Simulate payment --}}
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
    <script>
        // Format card number with spaces & update preview
        function onCardNumberInput(input) {
            let value = input.value.replace(/\D/g, '').substring(0, 16);
            input.value = value.replace(/(\d{4})(?=\d)/g, '$1 ');
            updatePreview();
        }

        // Format expiry as MM/YY
        function onExpiryInput(input) {
            let value = input.value.replace(/\D/g, '').substring(0, 4);
            if (value.length >= 3) {
                value = value.substring(0, 2) + '/' + value.substring(2);
            }
            input.value = value;
            updatePreview();
        }

        // Update visual card preview
        function updatePreview() {
            const number = document.getElementById('cardNumber').value || '';
            const name = document.getElementById('cardName').value || '';
            const expiry = document.getElementById('cardExpiry').value || '';

            // Number preview
            const digits = number.replace(/\D/g, '');
            let display = '';
            for (let i = 0; i < 16; i++) {
                if (i > 0 && i % 4 === 0) display += ' ';
                display += digits[i] || '•';
            }
            document.getElementById('previewNumber').textContent = display;

            // Name preview
            document.getElementById('previewName').textContent = name.toUpperCase() || 'YOUR NAME';

            // Expiry preview
            document.getElementById('previewExpiry').textContent = expiry || 'MM/YY';

            // Card brand icon
            const icon = document.getElementById('cardBrandIcon');
            if (digits.startsWith('4')) {
                icon.className = 'fab fa-cc-visa text-white/60 text-3xl';
            } else if (digits.startsWith('5') || digits.startsWith('2')) {
                icon.className = 'fab fa-cc-mastercard text-white/60 text-3xl';
            } else if (digits.startsWith('35')) {
                icon.className = 'fab fa-cc-jcb text-white/60 text-3xl';
            } else {
                icon.className = 'fab fa-cc-visa text-white/60 text-3xl';
            }
        }

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
    </script>
@endpush
