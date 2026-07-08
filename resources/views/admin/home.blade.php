@extends('layouts.admin')
@section('title', 'Dashboard — GiaSu247 Admin')

@section('content')

    {{-- Page Header --}}
    <div class="mb-6">
        <h1 class="text-xl font-bold text-gray-800">Dashboard</h1>
        <p class="text-sm text-gray-500 mt-0.5">Tổng quan hệ thống — {{ now()->format('d/m/Y') }}</p>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

        {{-- Gia sư --}}
        <div
            class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-all hover:-translate-y-0.5">
            <div class="flex items-center justify-between mb-4">
                <div class="w-11 h-11 bg-violet-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-chalkboard-teacher text-violet-600 text-lg"></i>
                </div>
                <a href="{{ route('admin.tutors.index') }}"
                    class="text-xs text-violet-600 hover:text-violet-800 font-medium hover:underline">
                    Xem tất cả →
                </a>
            </div>
            <p class="text-2xl font-bold text-gray-800">{{ $countTutors }}</p>
            <p class="text-sm text-gray-500 mt-0.5">Tổng gia sư</p>
        </div>

        {{-- Học viên --}}
        <div
            class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-all hover:-translate-y-0.5">
            <div class="flex items-center justify-between mb-4">
                <div class="w-11 h-11 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-user-graduate text-blue-600 text-lg"></i>
                </div>
                <a href="{{ route('admin.students.index') }}"
                    class="text-xs text-blue-600 hover:text-blue-800 font-medium hover:underline">
                    Xem tất cả →
                </a>
            </div>
            <p class="text-2xl font-bold text-gray-800">{{ $countStudents }}</p>
            <p class="text-sm text-gray-500 mt-0.5">Tổng học viên</p>
        </div>

        {{-- Lớp hoạt động --}}
        <div
            class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-all hover:-translate-y-0.5">
            <div class="flex items-center justify-between mb-4">
                <div class="w-11 h-11 bg-emerald-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-book-open text-emerald-600 text-lg"></i>
                </div>
                {{-- http://127.0.0.1:8000/admin/class-requests?status=assigned --}}
                <a href="{{ route('admin.class-requests.index') }}?status=assigned"
                    class="text-xs text-emerald-600 hover:text-emerald-800 font-medium hover:underline">
                    Xem tất cả →
                </a>
            </div>
            <p class="text-2xl font-bold text-gray-800">{{ $countActiveClasses }}</p>
            <p class="text-sm text-gray-500 mt-0.5">Lớp đang hoạt động</p>
        </div>

        {{-- Doanh thu --}}
        <div
            class="bg-linear-to-br from-violet-600 to-indigo-700 rounded-2xl p-5 shadow-sm relative overflow-hidden hover:shadow-md transition-all hover:-translate-y-0.5">
            <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
            <div class="w-11 h-11 bg-white/20 rounded-xl flex items-center justify-center mb-4">
                <i class="fas fa-coins text-white text-lg"></i>
            </div>
            <p class="text-2xl font-bold text-white">{{ number_format($revenueVnd, 0, ',', '.') }}đ</p>
            <p class="text-sm text-violet-200 mt-0.5">Doanh thu tháng</p>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- Gia sư chờ duyệt --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-2">
                <div class="w-7 h-7 bg-amber-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-amber-500 text-sm"></i>
                </div>
                <h3 class="font-bold text-gray-800 text-sm">Gia sư chờ duyệt</h3>
            </div>
            <div class="p-5">
                <p class="text-3xl font-bold text-amber-600 mb-1">{{ $pendingTutorsCount }}</p>
                <p class="text-xs text-gray-400 mb-4">đang chờ phê duyệt</p>
                <a href="{{ route('admin.tutors.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-semibold text-amber-600 hover:text-amber-800 transition">
                    Xem danh sách <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>

        {{-- Lớp chờ duyệt --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-2">
                <div class="w-7 h-7 bg-blue-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-file-circle-check text-blue-500 text-sm"></i>
                </div>
                <h3 class="font-bold text-gray-800 text-sm">Lớp học mới</h3>
            </div>
            <div class="p-5">
                <p class="text-3xl font-bold text-blue-600 mb-1">{{ $newClassRequestsCount }}</p>
                <p class="text-xs text-gray-400 mb-4">yêu cầu mới hôm nay</p>
                <a href="{{ route('admin.class-requests.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-semibold text-blue-600 hover:text-blue-800 transition">
                    Xem đơn đăng lớp <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>

        {{-- Liên hệ chưa trả lời --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-2">
                <div class="w-7 h-7 bg-rose-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-envelope text-rose-500 text-sm"></i>
                </div>
                <h3 class="font-bold text-gray-800 text-sm">Liên hệ mới</h3>
            </div>
            <div class="p-5">
                <p class="text-3xl font-bold text-rose-600 mb-1">{{ $unreadContactsCount }}</p>
                <p class="text-xs text-gray-400 mb-4">chưa được phản hồi</p>
                <a href="{{ route('admin.contacts.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-semibold text-rose-600 hover:text-rose-800 transition">
                    Xem liên hệ <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- Lịch sử nhận doanh thu --}}
    <div class="mt-8 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-bold text-gray-800 text-lg flex items-center gap-2">
                <i class="fas fa-history text-violet-600"></i> Lịch sử nhận doanh thu gần đây
            </h2>
            <a href="{{ route('admin.wallet-transactions.index') }}?type=charge" class="text-sm font-semibold text-violet-600 hover:text-violet-800 transition">
                Xem toàn bộ <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 text-xs text-gray-500 uppercase tracking-wider border-b border-gray-100">
                        <th class="px-6 py-4 font-semibold">Thời gian</th>
                        <th class="px-6 py-4 font-semibold">Gia sư</th>
                        <th class="px-6 py-4 font-semibold">Mô tả</th>
                        <th class="px-6 py-4 font-semibold text-right">Số tiền (VNĐ)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($revenueHistory as $transaction)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-6 py-4">
                                <span class="text-sm font-medium text-gray-800">{{ $transaction->created_at->format('d/m/Y') }}</span>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $transaction->created_at->format('H:i') }}</p>
                            </td>
                            <td class="px-6 py-4">
                                @if($transaction->wallet && $transaction->wallet->user)
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-violet-100 flex items-center justify-center shrink-0">
                                            @if($transaction->wallet->user->avatar)
                                                <img src="{{ asset('storage/' . $transaction->wallet->user->avatar) }}" class="w-full h-full rounded-full object-cover">
                                            @else
                                                <span class="text-violet-600 font-bold text-xs">{{ mb_substr($transaction->wallet->user->name, 0, 1) }}</span>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-800">{{ $transaction->wallet->user->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $transaction->wallet->user->email }}</p>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-sm text-gray-500">Người dùng ẩn</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-700">{{ $transaction->description }}</p>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="text-sm font-bold text-emerald-600">
                                    +{{ number_format($transaction->amount * 1000, 0, ',', '.') }}đ
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-file-invoice-dollar text-2xl text-gray-300"></i>
                                </div>
                                <p class="text-sm text-gray-500 font-medium">Chưa có lịch sử nhận doanh thu nào.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
