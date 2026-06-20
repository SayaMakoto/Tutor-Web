@php
    // Xác định role hiện tại để chọn layout & màu chủ thể phù hợp
    $isTutor = Auth::user()->role === 'tutor';
    $layout = $isTutor ? 'layouts.tutor' : 'layouts.student';

    // Bộ class màu dùng chung — đổi 1 chỗ, áp dụng toàn trang
    $theme = $isTutor
        ? [
            'gradFrom' => 'from-green-600',
            'gradTo' => 'to-emerald-700',
            'text' => 'text-green-600',
            'text500' => 'text-green-500',
            'text700' => 'text-green-700',
            'bg50' => 'bg-green-50',
            'bg100' => 'bg-green-100',
            'border400' => 'border-green-400',
            'border500' => 'border-green-500',
            'ring400' => 'focus:ring-green-400',
            'btnGradFrom' => 'from-green-600',
            'btnGradTo' => 'to-emerald-600',
            'btnHoverFrom' => 'hover:from-green-700',
            'btnHoverTo' => 'hover:to-emerald-700',
            'badgeBg' => 'bg-green-600',
            'badgeText' => 'text-white',
        ]
        : [
            'gradFrom' => 'from-blue-600',
            'gradTo' => 'to-indigo-600',
            'text' => 'text-blue-600',
            'text500' => 'text-blue-500',
            'text700' => 'text-blue-700',
            'bg50' => 'bg-blue-50',
            'bg100' => 'bg-blue-100',
            'border400' => 'border-blue-400',
            'border500' => 'border-blue-500',
            'ring400' => 'focus:ring-blue-400',
            'btnGradFrom' => 'from-blue-600',
            'btnGradTo' => 'to-indigo-600',
            'btnHoverFrom' => 'hover:from-blue-700',
            'btnHoverTo' => 'hover:to-indigo-700',
            'badgeBg' => 'bg-blue-600',
            'badgeText' => 'text-white',
        ];
@endphp
@extends($layout)
@section('title', 'Nạp Xu vào ví')

@section('content')
    <div class="max-w-2xl mx-auto space-y-6">

        {{-- Header --}}
        <div class="flex items-center gap-3">
            <a href="{{ route('payment.wallet') }}"
                class="w-9 h-9 bg-white border border-gray-200 rounded-xl flex items-center justify-center hover:bg-gray-50 transition">
                <i class="fas fa-arrow-left text-gray-500 text-sm"></i>
            </a>
            <div>
                <h1 class="text-xl font-bold text-gray-800">Nạp Xu vào ví</h1>
                <p class="text-sm text-gray-500">Chọn mệnh giá và phương thức thanh toán</p>
            </div>
        </div>

        {{-- Số dư hiện tại --}}
        <div
            class="bg-linear-to-r {{ $theme['gradFrom'] }} {{ $theme['gradTo'] }} rounded-2xl px-6 py-4 flex items-center justify-between text-white">
            <div class="flex items-center gap-3">
                <i class="fas fa-wallet text-white/70"></i>
                <span class="text-sm text-white/80">Số dư hiện tại</span>
            </div>
            <span class="text-xl font-bold">{{ number_format($wallet->balance ?? 0) }} Xu</span>
        </div>

        {{-- Chọn mệnh giá --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-tag {{ $theme['text500'] }} text-sm"></i> Chọn mệnh giá nạp
            </h3>

            <div class="grid grid-cols-2 gap-3 mb-4" id="presetGrid">
                @php
                    $presets = [
                        ['xu' => 100, 'vnd' => 100000, 'label' => '100.000đ', 'popular' => false],
                        ['xu' => 200, 'vnd' => 200000, 'label' => '200.000đ', 'popular' => true],
                        ['xu' => 500, 'vnd' => 500000, 'label' => '500.000đ', 'popular' => false],
                        ['xu' => 1000, 'vnd' => 1000000, 'label' => '1.000.000đ', 'popular' => false],
                    ];
                @endphp

                @foreach ($presets as $preset)
                    <button type="button" onclick="selectPreset({{ $preset['xu'] }}, {{ $preset['vnd'] }}, this)"
                        class="preset-btn relative border-2 border-gray-200 rounded-xl p-4 text-left
                                   hover:{{ $theme['border400'] }} hover:{{ $theme['bg50'] }} transition-all duration-150 group">
                        @if ($preset['popular'])
                            <span
                                class="absolute -top-2 -right-2 {{ $theme['badgeBg'] }} {{ $theme['badgeText'] }} text-xs px-2 py-0.5 rounded-full font-semibold">
                                Phổ biến
                            </span>
                        @endif
                        <p class="text-2xl font-bold text-gray-800 group-hover:{{ $theme['text700'] }}">
                            {{ $preset['xu'] }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">Xu</p>
                        <div class="mt-2 pt-2 border-t border-gray-100">
                            <p class="text-sm font-semibold {{ $theme['text'] }}">{{ $preset['label'] }}</p>
                            <p class="text-xs text-gray-400">1 Xu = 1.000 VNĐ</p>
                        </div>
                    </button>
                @endforeach
            </div>

            {{-- Custom amount --}}
            <div class="border-2 border-dashed border-gray-200 rounded-xl p-4 hover:{{ $theme['border400'] }} transition">
                <label class="block text-sm font-medium text-gray-600 mb-2">
                    <i class="fas fa-pencil text-xs mr-1"></i> Nhập số Xu tùy chỉnh
                </label>
                <div class="flex gap-2">
                    <div class="relative flex-1">
                        <input type="number" id="customXu" min="50" max="10000" step="50"
                            placeholder="Tối thiểu 50 Xu" oninput="updateCustomAmount(this.value)"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm
                                      focus:ring-2 {{ $theme['ring400'] }} focus:border-transparent focus:outline-none">
                        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">Xu</span>
                    </div>
                    <div class="flex items-center {{ $theme['bg50'] }} border {{ $theme['bg100'] }} rounded-xl px-4">
                        <span class="{{ $theme['text700'] }} font-semibold text-sm" id="customVnd">= 0 VNĐ</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Phương thức thanh toán --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-credit-card {{ $theme['text500'] }} text-sm"></i> Phương thức thanh toán
            </h3>

            <div class="space-y-3">
                {{-- QR VNPAY --}}
                <label
                    class="flex items-center gap-4 p-4 border-2 border-gray-200 rounded-xl cursor-pointer transition
                      hover:border-gray-300 hover:bg-gray-50
                      has-[:checked]:{{ $theme['border500'] }} has-[:checked]:{{ $theme['bg50'] }}">
                    <input type="radio" name="method" value="qr" checked class="{{ $theme['text'] }}">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-sm shrink-0">
                        <i class="fas fa-qrcode {{ $theme['text'] }} text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-gray-800 text-sm">Quét mã QR</p>
                        <p class="text-xs text-gray-500">VNPAY QR — Ngân hàng / Ví điện tử</p>
                    </div>
                    <span
                        class="text-xs {{ $theme['bg100'] }} {{ $theme['text700'] }} px-2 py-0.5 rounded-full font-medium">Khuyên
                        dùng</span>
                </label>

                {{-- ATM --}}
                <label
                    class="flex items-center gap-4 p-4 border-2 border-gray-200 rounded-xl cursor-pointer transition
                      hover:border-gray-300 hover:bg-gray-50
                      has-[:checked]:{{ $theme['border500'] }} has-[:checked]:{{ $theme['bg50'] }}">
                    <input type="radio" name="method" value="atm" class="{{ $theme['text'] }}">
                    <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center shrink-0">
                        <i class="fas fa-building-columns text-gray-500 text-lg"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-gray-800 text-sm">Thẻ ATM nội địa</p>
                        <p class="text-xs text-gray-500">Hơn 40 ngân hàng Việt Nam</p>
                    </div>
                </label>

                {{-- Quốc tế --}}
                <label
                    class="flex items-center gap-4 p-4 border-2 border-gray-200 rounded-xl cursor-pointer transition
                      hover:border-gray-300 hover:bg-gray-50
                      has-[:checked]:{{ $theme['border500'] }} has-[:checked]:{{ $theme['bg50'] }}">
                    <input type="radio" name="method" value="intl" class="{{ $theme['text'] }}">
                    <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center shrink-0">
                        <i class="fab fa-cc-visa text-gray-500 text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-gray-800 text-sm">Thẻ quốc tế</p>
                        <p class="text-xs text-gray-500">Visa / Mastercard / JCB</p>
                    </div>
                </label>
            </div>
            {{-- Order Summary --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-800 mb-3">Tóm tắt đơn hàng</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between text-gray-600">
                        <span>Số Xu nhận được</span>
                        <span class="font-semibold text-gray-800" id="summaryXu">— Xu</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Số tiền thanh toán</span>
                        <span class="font-semibold {{ $theme['text'] }}" id="summaryVnd">— VNĐ</span>
                    </div>
                    <div class="border-t border-gray-100 pt-2 flex justify-between">
                        <span class="font-semibold text-gray-800">Phí giao dịch</span>
                        <span class="text-emerald-600 font-semibold">Miễn phí</span>
                    </div>
                </div>
            </div>

            {{-- CTA --}}
            <form action="{{ route('payment.create') }}" method="POST" id="topupForm">
                @csrf
                <input type="hidden" name="coin_amount" id="hiddenCoin" value="">
                <input type="hidden" name="payment_method" id="hiddenMethod" value="qr">

                <button type="submit" id="submitBtn" disabled
                    class="w-full bg-linear-to-r {{ $theme['btnGradFrom'] }} {{ $theme['btnGradTo'] }} text-white
                           py-4 rounded-xl font-bold text-base shadow-sm
                           hover:shadow-lg {{ $theme['btnHoverFrom'] }} {{ $theme['btnHoverTo'] }}
                           transition-all duration-200 disabled:opacity-40 disabled:cursor-not-allowed
                           flex items-center justify-center gap-2">
                    <i class="fas fa-lock text-sm"></i>
                    <span>Thanh toán an toàn</span>
                </button>

                <p class="text-center text-xs text-gray-400 mt-3">
                    <i class="fas fa-shield-halved mr-1"></i>
                    Giao dịch được bảo mật bởi VNPAY
                </p>
            </form>

        </div>
    @endsection

    @push('scripts')
        <script>
            let selectedXu = 0;

            function selectPreset(xu, vnd, el) {
                document.querySelectorAll('.preset-btn').forEach(b => {
                    b.classList.remove('{{ $theme['border500'] }}', '{{ $theme['bg50'] }}');
                    b.classList.add('border-gray-200');
                });
                el.classList.add('{{ $theme['border500'] }}', '{{ $theme['bg50'] }}');
                el.classList.remove('border-gray-200');
                document.getElementById('customXu').value = '';
                document.getElementById('customVnd').textContent = '= 0 VNĐ';
                updateSummary(xu, vnd);
            }

            function updateCustomAmount(val) {
                document.querySelectorAll('.preset-btn').forEach(b => {
                    b.classList.remove('{{ $theme['border500'] }}', '{{ $theme['bg50'] }}');
                    b.classList.add('border-gray-200');
                });
                const xu = parseInt(val) || 0;
                const vnd = xu * 1000;
                document.getElementById('customVnd').textContent = '= ' + vnd.toLocaleString('vi-VN') + ' VNĐ';
                updateSummary(xu, vnd);
            }

            function updateSummary(xu, vnd) {
                selectedXu = xu;
                document.getElementById('summaryXu').textContent = xu.toLocaleString('vi-VN') + ' Xu';
                document.getElementById('summaryVnd').textContent = vnd.toLocaleString('vi-VN') + ' VNĐ';
                document.getElementById('hiddenCoin').value = xu;
                document.getElementById('submitBtn').disabled = xu < 50;
            }

            document.querySelectorAll('input[name="method"]').forEach(r => {
                r.addEventListener('change', () => {
                    document.getElementById('hiddenMethod').value = r.value;
                });
            });
        </script>
    @endpush
