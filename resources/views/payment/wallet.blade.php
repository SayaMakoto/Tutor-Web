@php
    // Bộ class màu dùng cho Gia sư (tông xanh lá/ngọc lục bảo)
    $theme = [
        'gradFrom' => 'from-green-600',
        'gradTo' => 'to-emerald-700',
        'solid' => 'bg-green-600',
        'solidHover' => 'hover:bg-green-700',
        'text' => 'text-green-600',
        'textDark' => 'text-green-800',
        'text700' => 'text-green-700',
        'bg50' => 'bg-green-50',
        'bg100' => 'bg-green-100',
        'border' => 'border-green-100',
        'btnGradFrom' => 'from-green-600',
        'btnGradTo' => 'to-emerald-600',
        'btnHoverFrom' => 'hover:from-green-700',
        'btnHoverTo' => 'hover:to-emerald-700',
    ];
@endphp
@extends($layout)
@section('title', 'Ví Xu của tôi')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">

        {{-- Page Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-wallet {{ $theme['text'] }}"></i> Ví Xu của tôi
                </h1>
                <p class="text-sm text-gray-500 mt-0.5">Quản lý số dư và lịch sử giao dịch</p>
            </div>
            <a href="{{ route('payment.topup') }}"
                class="inline-flex items-center gap-2 bg-linear-to-r {{ $theme['btnGradFrom'] }} {{ $theme['btnGradTo'] }}
                  text-white px-5 py-2.5 rounded-xl font-semibold text-sm shadow-sm
                  hover:shadow-md {{ $theme['btnHoverFrom'] }} {{ $theme['btnHoverTo'] }} transition-all">
                <i class="fas fa-plus"></i> Nạp thêm Xu
            </a>
        </div>

        {{-- Balance Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            {{-- Xu khả dụng --}}
            <div
                class="bg-linear-to-br {{ $theme['gradFrom'] }} {{ $theme['gradTo'] }} rounded-2xl p-6 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2">
                </div>
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mb-3">
                    <i class="fas fa-coins text-lg"></i>
                </div>
                <p class="text-white/80 text-sm mb-1">Xu khả dụng</p>
                <p class="text-3xl font-bold">{{ number_format($wallet->balance ?? 0) }}</p>
                <p class="text-white/70 text-xs mt-1">≈ {{ number_format(($wallet->balance ?? 0) * 1000) }} VNĐ</p>
            </div>

            {{-- Xu đang giữ --}}
            <div class="bg-white rounded-2xl p-6 border border-amber-100 relative overflow-hidden">
                <div class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center mb-3">
                    <i class="fas fa-lock text-amber-500 text-lg"></i>
                </div>
                <p class="text-gray-500 text-sm mb-1">Xu đang tạm giữ</p>
                <p class="text-3xl font-bold text-amber-600">{{ number_format($wallet->frozen_balance ?? 0) }}</p>
                <p class="text-gray-400 text-xs mt-1">Đang trong quá trình bảo hành lớp</p>
            </div>

            {{-- Tổng đã nạp --}}
            <div class="bg-white rounded-2xl p-6 border border-emerald-100">
                <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center mb-3">
                    <i class="fas fa-arrow-trend-up text-emerald-500 text-lg"></i>
                </div>
                <p class="text-gray-500 text-sm mb-1">Tổng đã nạp</p>
                <p class="text-3xl font-bold text-emerald-600">{{ number_format($wallet->total_topped_up ?? 0) }}</p>
                <p class="text-gray-400 text-xs mt-1">Xu tích lũy toàn thời gian</p>
            </div>

        </div>

        {{-- Hướng dẫn và Hoàn tiền --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Hướng dẫn sử dụng --}}
            <div class="{{ $theme['bg50'] }} border {{ $theme['border'] }} rounded-2xl p-5 flex items-start gap-4 h-full">
                <div class="w-10 h-10 {{ $theme['bg100'] }} rounded-xl flex items-center justify-center shrink-0">
                    <i class="fas fa-circle-info {{ $theme['text'] }}"></i>
                </div>
                <div>
                    <p class="font-semibold {{ $theme['textDark'] }} text-sm mb-1">Cơ chế Ví Xu hoạt động như thế nào?</p>
                    <ul class="{{ $theme['text700'] }} text-xs space-y-1.5">
                        <li><i class="fas fa-check-circle mr-1"></i> <strong>1 Xu = 1.000 VNĐ</strong> — Nạp tiền thật đổi lấy Xu</li>
                        <li><i class="fas fa-check-circle mr-1"></i> Khi học viên chọn bạn, hệ thống <strong>tạm khóa Xu</strong> (chưa trừ thật)</li>
                        <li><i class="fas fa-check-circle mr-1"></i> Sau bảo hành 7–15 ngày, Xu mới được <strong>khấu trừ thực tế</strong></li>
                        <li><i class="fas fa-check-circle mr-1"></i> Nếu lớp vỡ trong bảo hành, Xu được <strong>hoàn trả 100%</strong></li>
                    </ul>
                </div>
            </div>

            {{-- Yêu cầu hoàn tiền (Rút xu) --}}
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex flex-col justify-between h-full">
                <div>
                    <h3 class="font-bold text-gray-800 text-sm mb-1 flex items-center gap-2">
                        <i class="fas fa-reply-all text-red-500"></i> Yêu cầu hoàn tiền (Rút xu)
                    </h3>
                    <p class="text-xs text-gray-500 mb-4">Hoàn số xu khả dụng của bạn thành tiền mặt</p>
                </div>
                
                <form action="{{ route('payment.refund') }}" method="POST" class="space-y-3" id="refundForm">
                    @csrf
                    <div>
                        <div class="relative">
                            <input type="number" name="coin_amount" id="refundXu" min="1" max="{{ $wallet->balance ?? 0 }}" required
                                placeholder="Nhập số xu muốn hoàn (Tối đa: {{ number_format($wallet->balance ?? 0) }})"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-red-400 focus:border-transparent focus:outline-none">
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">Xu</span>
                        </div>
                        <div class="flex justify-between items-center mt-1">
                            <span class="text-xs text-gray-400" id="refundVndText">= 0 VNĐ</span>
                            <span class="text-xs text-gray-400">1 Xu = 1.000 VNĐ</span>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded-xl font-semibold text-sm transition-all duration-150 flex items-center justify-center gap-2 shadow-sm">
                        <i class="fas fa-rotate-left"></i> Hoàn Xu
                    </button>
                </form>
            </div>
        </div>

        {{-- Lịch sử giao dịch --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-clock-rotate-left {{ $theme['text'] }} text-sm"></i> Lịch sử giao dịch
                </h3>
                <span class="text-xs text-gray-400">30 giao dịch gần nhất</span>
            </div>

            @if (isset($transactions) && $transactions->count())
                <div class="divide-y divide-gray-50">
                    @foreach ($transactions as $txn)
                        @php
                            $typeConfig = [
                                'topup' => [
                                    'icon' => 'fas fa-plus-circle',
                                    'color' => 'text-emerald-600',
                                    'bg' => 'bg-emerald-50',
                                    'label' => 'Nạp Xu',
                                    'sign' => '+',
                                ],
                                'hold' => [
                                    'icon' => 'fas fa-lock',
                                    'color' => 'text-amber-600',
                                    'bg' => 'bg-amber-50',
                                    'label' => 'Tạm giữ',
                                    'sign' => '-',
                                ],
                                'charge' => [
                                    'icon' => 'fas fa-circle-minus',
                                    'color' => 'text-red-500',
                                    'bg' => 'bg-red-50',
                                    'label' => 'Khấu trừ',
                                    'sign' => '-',
                                ],
                                'refund' => [
                                    'icon' => 'fas fa-rotate-left',
                                    'color' => 'text-blue-600',
                                    'bg' => 'bg-blue-50',
                                    'label' => 'Hoàn tiền',
                                    'sign' => '+',
                                ],
                                'release' => [
                                    'icon' => 'fas fa-rotate-left',
                                    'color' => 'text-red-500',
                                    'bg' => 'bg-red-50',
                                    'label' => 'Hoàn xu',
                                    'sign' => '-',
                                ],
                            ];
                            $cfg = $typeConfig[$txn->type] ?? $typeConfig['topup'];
                        @endphp
                        <div class="px-6 py-4 flex items-center gap-4 hover:bg-gray-50 transition">
                            <div
                                class="w-10 h-10 {{ $cfg['bg'] }} rounded-xl flex items-center justify-center shrink-0">
                                <i class="{{ $cfg['icon'] }} {{ $cfg['color'] }} text-sm"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-gray-800 text-sm">{{ $cfg['label'] }}</p>
                                <p class="text-xs text-gray-400 truncate">{{ $txn->description ?? 'Giao dịch ví' }}</p>
                            </div>
                            <div class="text-right">
                                <p
                                    class="font-bold {{ in_array($txn->type, ['topup', 'refund']) ? 'text-emerald-600' : 'text-red-500' }} text-sm">
                                    {{ $cfg['sign'] }}{{ number_format($txn->amount) }} Xu
                                </p>
                                <p class="text-xs text-gray-400">{{ $txn->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-14 h-14 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-receipt text-gray-300 text-xl"></i>
                    </div>
                    <p class="text-gray-500 font-medium text-sm">Chưa có giao dịch nào</p>
                    <p class="text-gray-400 text-xs mt-1">Nạp Xu để bắt đầu nhận lớp</p>
                    <a href="{{ route('payment.topup') }}"
                        class="mt-4 inline-flex items-center gap-2 {{ $theme['solid'] }} text-white px-5 py-2 rounded-xl text-sm font-semibold {{ $theme['solidHover'] }} transition">
                        <i class="fas fa-plus"></i> Nạp Xu ngay
                    </a>
                </div>
            @endif
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const refundXuInput = document.getElementById('refundXu');
            const refundVndText = document.getElementById('refundVndText');
            if (refundXuInput && refundVndText) {
                refundXuInput.addEventListener('input', function() {
                    const xu = parseInt(this.value) || 0;
                    const vnd = xu * 1000;
                    refundVndText.textContent = '= ' + vnd.toLocaleString('vi-VN') + ' VNĐ';
                });
            }
        });
    </script>
@endpush
