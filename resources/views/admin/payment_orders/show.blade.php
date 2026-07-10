@extends('layouts.admin')
@section('title', 'Chi tiết hóa đơn #' . $order->order_ref)

@section('content')

    {{-- Back Link --}}
    <div class="mb-5">
        <a href="{{ route('admin.payment-orders.index') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-gray-500 hover:text-violet-600 transition">
            <i class="fas fa-arrow-left text-xs"></i> Quay lại danh sách
        </a>
    </div>

    {{-- Page Header --}}
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-800">Chi tiết hóa đơn #{{ $order->order_ref }}</h1>
            <p class="text-sm text-gray-500 mt-0.5">Thông tin chi tiết hóa đơn thanh toán bằng VNĐ</p>
        </div>
    </div>

    {{-- Main Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left Column: Details & Gateway Response --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- General Info Card --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-bold text-gray-800 text-base mb-4 pb-2 border-b border-gray-50">
                    <i class="fas fa-circle-info text-violet-500 mr-1.5"></i> Thông tin tổng quan hóa đơn
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-6 text-sm">
                    <div>
                        <p class="text-xs text-gray-400 font-medium font-sans">Mã hóa đơn hệ thống (ID)</p>
                        <p class="font-semibold text-gray-800 mt-0.5">#{{ $order->id }}</p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-400 font-medium">Mã tham chiếu đơn hàng (order_ref)</p>
                        <p class="font-semibold text-gray-800 mt-0.5 font-mono text-xs">{{ $order->order_ref }}</p>
                    </div>

                    @if($order->class_request_id)
                    <div>
                        <p class="text-xs text-gray-400 font-medium font-sans">Lớp học liên quan (class_request_id)</p>
                        <a href="{{ route('admin.class-requests.show', $order->class_request_id) }}"
                           class="font-semibold text-violet-600 hover:text-violet-800 mt-0.5 block hover:underline">
                            Lớp học #{{ $order->class_request_id }} <i class="fas fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                    @else
                    <div>
                        <p class="text-xs text-gray-400 font-medium font-sans">Loại hóa đơn</p>
                        <p class="font-semibold text-gray-700 mt-0.5">Thanh toán trực tiếp</p>
                    </div>
                    @endif

                    <div>
                        <p class="text-xs text-gray-400 font-medium">Số tiền thanh toán (amount_vnd)</p>
                        <p class="font-semibold text-gray-800 mt-0.5">{{ number_format($order->amount_vnd) }}đ</p>
                    </div>

                    @php
                        $statusBg = 'bg-gray-100 text-gray-700';
                        $statusLabel = $order->status;
                        if ($order->status === 'success') {
                            $statusBg = 'bg-emerald-100 text-emerald-700';
                            $statusLabel = 'Thành công';
                        } elseif ($order->status === 'pending') {
                            $statusBg = 'bg-amber-100 text-amber-700';
                            $statusLabel = 'Chờ thanh toán';
                        } elseif ($order->status === 'failed') {
                            $statusBg = 'bg-rose-100 text-rose-700';
                            $statusLabel = 'Thất bại';
                        } elseif ($order->status === 'expired') {
                            $statusBg = 'bg-gray-250 text-gray-500';
                            $statusLabel = 'Hết hạn';
                        }
                    @endphp
                    <div>
                        <p class="text-xs text-gray-400 font-medium font-sans">Trạng thái (status)</p>
                        <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold mt-1.5 {{ $statusBg }}">
                            {{ $statusLabel }}
                        </span>
                    </div>

                    <div>
                        <p class="text-xs text-gray-400 font-medium">Phương thức (payment_method)</p>
                        <p class="font-semibold text-gray-800 mt-0.5 capitalize">{{ $order->payment_method ?: 'VNPAY' }}</p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-400 font-medium">Mã giao dịch VNPAY (vnpay_txn_no)</p>
                        <p class="font-semibold text-gray-850 mt-0.5 font-mono text-xs">
                            {{ $order->vnpay_txn_no ?: 'N/A (Chưa tạo giao dịch/chuyển khoản)' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-400 font-medium">Thời gian hết hạn (expires_at)</p>
                        <p class="font-semibold text-gray-800 mt-0.5">
                            {{ $order->expires_at ? $order->expires_at->format('d/m/Y H:i:s') : 'N/A' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-400 font-medium">Ngày khởi tạo (created_at)</p>
                        <p class="font-semibold text-gray-800 mt-0.5">{{ $order->created_at?->format('d/m/Y H:i:s') ?? 'N/A' }}</p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-400 font-medium">Cập nhật lần cuối (updated_at)</p>
                        <p class="font-semibold text-gray-800 mt-0.5">{{ $order->updated_at?->format('d/m/Y H:i:s') ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            {{-- Gateway Response JSON Prettified --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-bold text-gray-800 text-base mb-4 pb-2 border-b border-gray-50">
                    <i class="fas fa-code text-violet-500 mr-1.5"></i> Phản hồi từ cổng thanh toán (gateway_response)
                </h3>

                @if($order->gateway_response)
                    <pre class="font-mono text-xs p-4 bg-gray-50 border border-gray-100 rounded-xl overflow-x-auto text-gray-700 max-h-96 leading-relaxed">{{ json_encode($order->gateway_response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                @else
                    <p class="text-sm text-gray-400 italic">Không có dữ liệu phản hồi (chưa thực hiện thanh toán qua cổng).</p>
                @endif
            </div>

        </div>

        {{-- Right Column: User & Side Stats --}}
        <div class="space-y-6">

            {{-- Người nạp --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <h3 class="font-bold text-gray-800 text-sm mb-3.5 pb-2 border-b border-gray-50">
                    <i class="fas fa-user-circle text-violet-500 mr-1.5"></i> Người thực hiện nạp
                </h3>

                @if($order->user)
                    @php $user = $order->user; @endphp
                    <div class="flex items-center gap-3">
                        <img src="{{ $user->avatar
                            ? asset('storage/' . $user->avatar)
                            : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=7c3aed&color=fff' }}"
                             class="w-11 h-11 rounded-full object-cover border border-gray-100" alt="avatar">
                        <div class="min-w-0">
                            <p class="font-bold text-gray-800 text-sm truncate">{{ $user->name }}</p>
                            <p class="text-xs text-gray-400 truncate font-mono">{{ $user->email }}</p>
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

        </div>

    </div>

@endsection
