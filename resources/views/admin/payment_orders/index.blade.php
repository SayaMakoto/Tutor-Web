@extends('layouts.admin')
@section('title', 'Quản lý hóa đơn thanh toán')

@section('content')

    {{-- Page Header --}}
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-800">Hóa đơn thanh toán</h1>
            <p class="text-sm text-gray-500 mt-0.5">Quản lý các khoản thanh toán phí nhận lớp bằng VNĐ</p>
        </div>
    </div>

    {{-- Filters Card --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mb-6">
        <form action="{{ route('admin.payment-orders.index') }}" method="GET" class="flex flex-wrap items-center gap-3">
            <div class="flex-1 min-w-50">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                        <i class="fas fa-search text-xs"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="w-full pl-9 pr-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-hidden focus:border-violet-500 transition-colors"
                        placeholder="Tìm theo tên, email, mã tham chiếu...">
                </div>
            </div>

            <div class="w-48">
                <select name="status"
                    class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-hidden focus:border-violet-500 transition-colors">
                    <option value="">-- Tất cả trạng thái --</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Chờ thanh toán</option>
                    <option value="success" {{ request('status') === 'success' ? 'selected' : '' }}>Thành công</option>
                    <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Thất bại</option>
                    <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Hết hạn</option>
                </select>
            </div>

            <div class="flex items-center gap-2">
                <button type="submit"
                    class="px-4 py-2 bg-violet-600 hover:bg-violet-750 text-white rounded-xl text-sm font-semibold transition">
                    Lọc
                </button>
                @if (request()->anyFilled(['search', 'status']))
                    <a href="{{ route('admin.payment-orders.index') }}"
                        class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl text-sm font-semibold transition">
                        Xóa lọc
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Orders Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">ID
                        </th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Mã đơn (Ref)
                        </th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Người dùng</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Số
                            tiền (VND)</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">
                            Trạng thái</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Phương thức
                        </th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Ngày tạo</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">
                            Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($orders as $order)
                        @php
                            $user = $order->user;

                            // Trạng thái badge
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
                        <tr class="hover:bg-gray-50/70 transition">
                            <td class="px-5 py-3.5 text-center font-mono text-xs text-gray-500">
                                #{{ $order->id }}
                            </td>
                            <td class="px-5 py-3.5 font-semibold font-mono text-xs text-gray-800">
                                {{ $order->order_ref }}
                            </td>
                            <td class="px-5 py-3.5">
                                @if ($user)
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $user->name }}</p>
                                        <p class="text-xs text-gray-400 font-mono">{{ $user->email }}</p>
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400 italic">N/A (Người dùng đã bị xóa)</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-right text-gray-600 font-medium">
                                {{ number_format($order->amount_vnd) }}đ
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                <span
                                    class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $statusBg }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-xs text-gray-500 capitalize">
                                {{ $order->payment_method ?: 'VNPAY' }}
                            </td>
                            <td class="px-5 py-3.5 text-xs text-gray-500">
                                {{ $order->created_at?->format('d/m/Y H:i') ?? 'N/A' }}
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                <a href="{{ route('admin.payment-orders.show', $order->id) }}"
                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-violet-50 hover:bg-violet-100 text-violet-600 rounded-lg text-xs font-semibold transition">
                                    <i class="fas fa-eye text-xs"></i> Xem chi tiết
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-8 text-center text-gray-400">
                                <i class="fas fa-credit-card text-2xl mb-2 block"></i>
                                Không tìm thấy hóa đơn thanh toán nào.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($orders->hasPages())
            <div class="px-5 py-4 border-t border-gray-100">
                {{ $orders->links() }}
            </div>
        @endif
    </div>

@endsection
