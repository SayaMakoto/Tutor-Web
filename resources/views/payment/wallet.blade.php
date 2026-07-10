@php
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
    ];
@endphp
@extends($layout)
@section('title', 'Lịch sử thanh toán')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">

        {{-- Page Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-receipt {{ $theme['text'] }}"></i> Lịch sử thanh toán
                </h1>
                <p class="text-sm text-gray-500 mt-0.5 font-sans">Theo dõi các khoản phí nhận lớp và bảo lãnh trung gian</p>
            </div>
        </div>

        {{-- Escrow Alert / Info --}}
        <div class="bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-2xl flex items-start gap-3 text-sm">
            <i class="fas fa-shield-halved text-blue-600 text-lg mt-0.5 shrink-0"></i>
            <div>
                <strong class="font-semibold block mb-0.5">Thông báo pháp lý về bãi bỏ Ví tiền ảo:</strong>
                <p class="text-xs text-blue-700 leading-relaxed font-sans">
                    Tuân thủ quy định pháp luật Việt Nam hiện hành, GiaSu247 đã bãi bỏ hoàn toàn cơ chế Ví Xu (tài sản ảo
                    nội bộ). Mọi giao dịch thanh toán phí nhận lớp hiện được thực hiện trực tiếp bằng <strong>Đồng Việt Nam
                        (VNĐ)</strong> qua chuyển khoản ngân hàng/cổng thanh toán.
                </p>
            </div>
        </div>

        {{-- Balance Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            {{-- Tiền đang tạm giữ (Escrow) --}}
            <div
                class="bg-linear-to-br {{ $theme['gradFrom'] }} {{ $theme['gradTo'] }} rounded-2xl p-6 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2">
                </div>
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mb-3">
                    <i class="fas fa-lock text-lg"></i>
                </div>
                <p class="text-white/80 text-sm mb-1">Phí đang bảo lãnh</p>
                <p class="text-3xl font-bold font-sans">{{ number_format($escrowBalance) }}đ</p>
                <p class="text-white/70 text-xs mt-1 font-sans">Số tiền đang bị đóng băng trong giai đoạn học thử</p>
            </div>

            {{-- Cơ chế hoạt động --}}
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-xs flex flex-col justify-between">
                <div>
                    <h3 class="font-bold text-gray-800 text-sm mb-2"><i
                            class="fas fa-circle-question text-violet-500 mr-1"></i> Cơ chế Bảo lãnh trung gian</h3>
                    <ul class="text-gray-600 text-xs space-y-1.5 leading-relaxed font-sans">
                        <li><i class="fas fa-check-circle text-emerald-500 mr-1"></i> <strong>Đóng băng:</strong> Phí 25%
                            được chuyển và đóng băng khi nhận lớp.</li>
                        <li><i class="fas fa-check-circle text-emerald-500 mr-1"></i> <strong>Hủy lớp thử:</strong> Hoàn trả
                            20% phí cho bạn, hệ thống thu 5% phí.</li>
                        <li><i class="fas fa-check-circle text-emerald-500 mr-1"></i> <strong>Hoàn thành lớp:</strong> Giải
                            ngân toàn bộ 25% cho hệ thống.</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Transactions History Table --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-bold text-gray-800 text-sm">Lịch sử giao dịch ví của tôi</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Mã GD</th>
                            <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Ngày GD</th>
                            <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Loại giao
                                dịch</th>
                            <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Số
                                tiền</th>
                            <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Mô tả</th>
                            <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">
                                Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($transactions as $txn)
                            @php
                                $typeCfg = \App\Models\PaymentTransaction::TYPES[$txn->type] ?? [
                                    'label' => 'Không rõ',
                                    'color' => 'text-gray-500',
                                    'sign' => '',
                                ];
                                $statusBg =
                                    $txn->status === 'completed'
                                        ? 'bg-emerald-50 text-emerald-700'
                                        : 'bg-amber-50 text-amber-700';
                                $statusLabel = $txn->status === 'completed' ? 'Thành công' : 'Đang xử lý';
                            @endphp
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-5 py-3.5 text-xs font-mono text-gray-500">
                                    #{{ $txn->id }}
                                </td>
                                <td class="px-5 py-3.5 text-xs text-gray-500">
                                    {{ $txn->created_at?->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-5 py-3.5">
                                    <span
                                        class="inline-flex items-center gap-1 text-xs font-semibold {{ $typeCfg['color'] }}">
                                        <i
                                            class="fas {{ $txn->type === 'hold' ? 'fa-lock' : ($txn->type === 'refund' ? 'fa-rotate-left' : 'fa-arrow-trend-down') }} text-[10px]"></i>
                                        {{ $typeCfg['label'] }}
                                    </span>
                                </td>
                                <td class="px-5 py-3.5 text-right font-bold text-sm">
                                    <span class="{{ $typeCfg['sign'] === '+' ? 'text-emerald-600' : 'text-rose-600' }}">
                                        {{ $typeCfg['sign'] }}{{ number_format($txn->amount) }}đ
                                    </span>
                                </td>
                                <td class="px-5 py-3.5 text-xs text-gray-600">
                                    {{ $txn->description }}
                                </td>
                                <td class="px-5 py-3.5 text-center">
                                    <span
                                        class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $statusBg }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-8 text-center text-gray-400">
                                    <i class="fas fa-receipt text-2xl mb-2 block"></i>
                                    Không có giao dịch nào được ghi nhận.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
