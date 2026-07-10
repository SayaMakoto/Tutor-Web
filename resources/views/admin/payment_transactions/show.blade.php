@extends('layouts.admin')
@section('title', 'Chi tiết giao dịch #' . $transaction->id)

@section('content')

    {{-- Back Link --}}
    <div class="mb-5">
        <a href="{{ route('admin.payment-transactions.index') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-gray-500 hover:text-violet-600 transition">
            <i class="fas fa-arrow-left text-xs"></i> Quay lại danh sách
        </a>
    </div>

    {{-- Page Header --}}
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-800">Chi tiết giao dịch #{{ $transaction->id }}</h1>
            <p class="text-sm text-gray-500 mt-0.5">Thông tin chi tiết và tham chiếu của giao dịch thanh toán</p>
        </div>
    </div>

    {{-- Main Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left: Transaction Details --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-bold text-gray-800 text-base mb-4 pb-2 border-b border-gray-50">
                    <i class="fas fa-file-invoice text-violet-500 mr-1.5"></i> Thông tin giao dịch
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-6 text-sm">
                    <div>
                        <p class="text-xs text-gray-400 font-medium">Mã giao dịch</p>
                        <p class="font-semibold text-gray-800 mt-0.5 font-mono">#{{ $transaction->id }}</p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-400 font-medium">Ngày thực hiện</p>
                        <p class="font-semibold text-gray-800 mt-0.5">{{ $transaction->created_at?->format('d/m/Y H:i:s') ?? 'N/A' }}</p>
                    </div>

                    @php
                        $typeCfg = \App\Models\PaymentTransaction::TYPES[$transaction->type] ?? [
                            'label' => 'Không rõ', 'color' => 'text-gray-500', 'sign' => ''
                        ];
                    @endphp
                    <div>
                        <p class="text-xs text-gray-400 font-medium">Loại giao dịch</p>
                        <span class="inline-flex items-center gap-1 text-xs font-bold mt-1.5 {{ $typeCfg['color'] }}">
                            <i class="fas {{ $transaction->type === 'hold' ? 'fa-lock' : ($transaction->type === 'refund' ? 'fa-rotate-left' : 'fa-arrow-trend-down') }} text-[10px]"></i>
                            {{ $typeCfg['label'] }}
                        </span>
                    </div>

                    <div>
                        <p class="text-xs text-gray-400 font-medium">Số tiền giao dịch</p>
                        <p class="font-bold text-base mt-0.5 {{ $typeCfg['sign'] === '+' ? 'text-emerald-600' : 'text-rose-600' }}">
                            {{ $typeCfg['sign'] }}{{ number_format($transaction->amount) }}đ
                        </p>
                    </div>

                    @php
                        $statusBg = 'bg-gray-100 text-gray-700';
                        $statusLabel = $transaction->status;
                        if ($transaction->status === 'completed') {
                            $statusBg = 'bg-emerald-100 text-emerald-700';
                            $statusLabel = 'Thành công';
                        } elseif ($transaction->status === 'pending') {
                            $statusBg = 'bg-amber-100 text-amber-700';
                            $statusLabel = 'Đang xử lý';
                        } elseif ($transaction->status === 'failed') {
                            $statusBg = 'bg-rose-100 text-rose-700';
                            $statusLabel = 'Thất bại';
                        }
                    @endphp
                    <div>
                        <p class="text-xs text-gray-400 font-medium">Trạng thái</p>
                        <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold mt-1.5 {{ $statusBg }}">
                            {{ $statusLabel }}
                        </span>
                    </div>

                    <div class="sm:col-span-2">
                        <p class="text-xs text-gray-400 font-medium">Mô tả giao dịch</p>
                        <p class="font-medium text-gray-700 mt-1 bg-gray-50/70 p-3 rounded-xl border border-gray-100 italic">
                            {{ $transaction->description ?: 'Không có mô tả.' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: User & References --}}
        <div class="space-y-6">

            {{-- Người thực hiện --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <h3 class="font-bold text-gray-800 text-sm mb-3.5 pb-2 border-b border-gray-50">
                    <i class="fas fa-user-circle text-violet-500 mr-1.5"></i> Người thực hiện
                </h3>

                @if($transaction->user)
                    @php $user = $transaction->user; @endphp
                    <div class="flex items-center gap-3">
                        <img src="{{ $user->avatar
                            ? asset('storage/' . $user->avatar)
                            : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=7c3aed&color=fff' }}"
                             class="w-11 h-11 rounded-full object-cover border border-gray-100" alt="avatar">
                        <div class="min-w-0">
                            <p class="font-bold text-gray-800 text-sm truncate">{{ $user->name }}</p>
                            <p class="text-xs text-gray-400 truncate">{{ $user->email }}</p>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-t border-gray-100 flex gap-2">
                        @if($user->tutor)
                            <a href="{{ route('admin.tutors.show', $user->tutor->id) }}"
                               class="flex-1 text-center py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 rounded-xl text-xs font-semibold transition">
                                <i class="fas fa-chalkboard-teacher mr-1"></i> Hồ sơ Gia sư
                            </a>
                        @endif
                        @if($user->student)
                            <a href="{{ route('admin.students.show', $user->student->id) }}"
                               class="flex-1 text-center py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-xl text-xs font-semibold transition">
                                <i class="fas fa-user-graduate mr-1"></i> Hồ sơ Học viên
                            </a>
                        @endif
                    </div>
                @else
                    <span class="text-xs text-gray-400 italic">Người dùng đã bị xóa khỏi hệ thống.</span>
                @endif
            </div>

            {{-- Tham chiếu hóa đơn & lớp học --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <h3 class="font-bold text-gray-800 text-sm mb-3.5 pb-2 border-b border-gray-50">
                    <i class="fas fa-link text-violet-500 mr-1.5"></i> Tài liệu tham chiếu
                </h3>

                <div class="space-y-4">
                    {{-- Liên kết hóa đơn nạp tiền --}}
                    <div>
                        <p class="text-xs text-gray-400 font-medium">Hóa đơn thanh toán tương ứng</p>
                        @if($transaction->paymentOrder)
                            <div class="mt-1.5 flex items-center justify-between p-2.5 bg-gray-50 border border-gray-100 rounded-xl">
                                <div class="min-w-0">
                                    <p class="text-xs font-semibold text-gray-800 truncate font-mono">Ref: {{ $transaction->payment_order_ref }}</p>
                                    <p class="text-[10px] text-gray-400">Số tiền: {{ number_format($transaction->paymentOrder->amount_vnd) }}đ</p>
                                </div>
                                <a href="{{ route('admin.payment-orders.show', $transaction->paymentOrder->id) }}"
                                   class="px-2.5 py-1 bg-violet-600 text-white rounded-lg text-[11px] font-bold hover:bg-violet-700 transition shrink-0 ml-2">
                                    Xem hóa đơn
                                </a>
                            </div>
                        @elseif($transaction->payment_order_ref)
                            <div class="mt-1.5 flex items-center justify-between p-2.5 bg-gray-50 border border-gray-100 rounded-xl">
                                <div class="min-w-0">
                                    <p class="text-xs font-semibold text-gray-500 truncate font-mono">Ref: {{ $transaction->payment_order_ref }}</p>
                                    <p class="text-[10px] text-gray-400">Đơn hàng tham chiếu</p>
                                </div>
                                <span class="text-[10px] text-gray-400 italic">Mô phỏng/Không có VNPAY ID</span>
                            </div>
                        @else
                            <p class="text-xs text-gray-400 mt-1 italic">Không có hóa đơn thanh toán trực tiếp</p>
                        @endif
                    </div>

                    {{-- Liên kết lớp học --}}
                    <div>
                        <p class="text-xs text-gray-400 font-medium">Lớp học liên quan</p>
                        @if($transaction->classRequest)
                            <div class="mt-1.5 flex items-center justify-between p-2.5 bg-gray-50 border border-gray-100 rounded-xl">
                                <div class="min-w-0">
                                    <p class="text-xs font-semibold text-gray-800 truncate">Lớp học #{{ $transaction->class_request_id }}</p>
                                    <p class="text-[10px] text-gray-450 truncate">{{ $transaction->classRequest->subject?->name ?? 'Môn học khác' }} - {{ $transaction->classRequest->grade?->name }}</p>
                                </div>
                                <a href="{{ route('admin.class-requests.show', $transaction->class_request_id) }}"
                                   class="px-2.5 py-1 bg-violet-600 text-white rounded-lg text-[11px] font-bold hover:bg-violet-700 transition shrink-0 ml-2">
                                    Xem lớp
                                </a>
                            </div>
                        @else
                            <p class="text-xs text-gray-400 mt-1 italic">Không có lớp học liên quan</p>
                        @endif
                    </div>
                </div>
            </div>

        </div>

    </div>

@endsection
