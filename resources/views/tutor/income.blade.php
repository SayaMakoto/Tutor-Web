@extends($layout)

@section('title', 'Thu nhập gia sư')

@section('content')
    <div class="max-w-6xl mx-auto">

        {{-- Page Header --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Thu nhập</h1>
            <p class="text-sm text-gray-500 mt-1">Tổng quan thu nhập và lịch sử giao dịch</p>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

            {{-- Thu nhập thực nhận --}}
            <div class="bg-linear-to-br from-green-600 to-emerald-600 p-5 rounded-2xl shadow-sm text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                <div class="relative z-10">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mb-3">
                        <i class="fas fa-wallet text-lg"></i>
                    </div>
                    <p class="text-xl font-bold">{{ number_format($totalNetIncome) }}đ</p>
                    <p class="text-xs text-green-100 mt-0.5">Thu nhập thực nhận</p>
                </div>
            </div>

            {{-- Thu nhập dự kiến --}}
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-coins text-emerald-600 text-lg"></i>
                    </div>
                    <div>
                        <p class="text-xl font-bold text-gray-800">{{ number_format($expectedNetIncome) }}đ</p>
                        <p class="text-xs text-gray-500">Thu nhập dự kiến (đang dạy)</p>
                    </div>
                </div>
            </div>

            {{-- Tổng phí đã trả --}}
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-rose-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-percentage text-rose-600 text-lg"></i>
                    </div>
                    <div>
                        <p class="text-xl font-bold text-gray-800">{{ number_format($totalPlatformFee) }}đ</p>
                        <p class="text-xs text-gray-500">Phí nhận lớp đã trả (25%)</p>
                    </div>
                </div>
            </div>

            {{-- Tổng số lớp --}}
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-chalkboard-teacher text-blue-600 text-lg"></i>
                    </div>
                    <div>
                        <p class="text-xl font-bold text-gray-800">{{ $activeClasses->count() + $completedClasses->count() }}</p>
                        <p class="text-xs text-gray-500">Tổng số lớp tham gia</p>
                    </div>
                </div>
            </div>

        </div>


        {{-- Income by Class --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-8">

            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-lg font-bold text-gray-800">Thu nhập theo lớp</h2>
                <p class="text-xs text-gray-400 mt-0.5">Chi tiết thu nhập ước tính từ từng lớp</p>
            </div>

            @if (count($classIncomes) === 0)
                <div class="text-center py-14">
                    <i class="fas fa-piggy-bank text-gray-300 text-4xl mb-3"></i>
                    <p class="text-gray-500 font-medium">Chưa có thu nhập nào</p>
                    <p class="text-gray-400 text-sm mt-1">Hãy nhận lớp để bắt đầu kiếm thu nhập!</p>
                    <a href="{{ route('tutor.classes.index') }}"
                       class="inline-flex items-center gap-2 mt-4 bg-green-600 text-white text-sm font-semibold px-5 py-2.5 rounded-xl hover:bg-green-700 transition shadow-sm">
                        <i class="fas fa-search"></i> Tìm lớp ngay
                    </a>
                </div>
            @else
                {{-- Desktop Table --}}
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50/80">
                                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Lớp học</th>
                                <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Học phí/giờ</th>
                                <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Lịch học</th>
                                <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Tổng giá trị</th>
                                <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Phí nhận lớp</th>
                                <th class="px-5 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Thực nhận</th>
                                <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach ($classIncomes as $ci)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0
                                                        {{ $ci['status'] === 'active' ? 'bg-green-100' : ($ci['status'] === 'completed' ? 'bg-emerald-100' : 'bg-amber-100') }}">
                                                <i class="fas fa-book text-sm
                                                          {{ $ci['status'] === 'active' ? 'text-green-600' : ($ci['status'] === 'completed' ? 'text-emerald-600' : 'text-amber-600') }}"></i>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-800">{{ $ci['subject'] }}</p>
                                                <p class="text-xs text-gray-400">
                                                    {{ $ci['grade'] }}
                                                    <span class="mx-1">·</span>
                                                    {{ $ci['study_type'] === 'online' ? 'Online' : 'Offline' }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 text-center">
                                        <span class="text-sm font-medium text-gray-700">{{ number_format($ci['fee_per_hour']) }}đ</span>
                                    </td>
                                    <td class="px-5 py-4 text-center">
                                        <div class="text-sm text-gray-600">{{ $ci['sessions_per_week'] }} buổi/tuần</div>
                                        <div class="text-xs text-gray-400">Tổng {{ $ci['weeks'] }}</div>
                                    </td>
                                    <td class="px-5 py-4 text-center">
                                        <span class="text-sm text-gray-600">{{ number_format($ci['total_value']) }}đ</span>
                                    </td>
                                    <td class="px-5 py-4 text-center">
                                        <span class="text-sm text-rose-500">-{{ number_format($ci['platform_fee']) }}đ</span>
                                    </td>
                                    <td class="px-5 py-4 text-right">
                                        <span class="text-sm font-bold {{ $ci['status'] === 'active' ? 'text-green-600' : 'text-gray-800' }}">
                                            {{ number_format($ci['net_income']) }}đ
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 text-center">
                                        <span class="inline-flex items-center gap-1.5 text-xs font-medium px-2.5 py-1 rounded-full {{ $ci['status_color'] }}">
                                            @if ($ci['status'] === 'active')
                                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                            @endif
                                            {{ $ci['status_label'] }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-green-50/50 border-t border-green-100">
                                <td colspan="5" class="px-5 py-3 text-sm font-bold text-gray-700 text-right">
                                    <i class="fas fa-calculator mr-1 text-green-600"></i>
                                    Tổng thu nhập thực nhận (đã hoàn thành)
                                </td>
                                <td colspan="2" class="px-5 py-3 text-left text-base font-bold text-green-600">
                                    {{ number_format($totalNetIncome) }}đ
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                {{-- Mobile Cards --}}
                <div class="md:hidden p-4 flex flex-col gap-3">
                    @foreach ($classIncomes as $ci)
                        <div class="bg-gray-50 rounded-xl p-4">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-9 h-9 rounded-lg flex items-center justify-center
                                                {{ $ci['status'] === 'active' ? 'bg-green-100' : ($ci['status'] === 'completed' ? 'bg-emerald-100' : 'bg-amber-100') }}">
                                        <i class="fas fa-book text-sm
                                                  {{ $ci['status'] === 'active' ? 'text-green-600' : ($ci['status'] === 'completed' ? 'text-emerald-600' : 'text-amber-600') }}"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">{{ $ci['subject'] }}</p>
                                        <p class="text-xs text-gray-400">{{ $ci['grade'] }} · {{ $ci['study_type'] === 'online' ? 'Online' : 'Offline' }}</p>
                                    </div>
                                </div>
                                <span class="inline-flex items-center gap-1 text-[10px] font-medium px-2 py-1 rounded-full {{ $ci['status_color'] }}">
                                    {{ $ci['status_label'] }}
                                </span>
                            </div>
                            <div class="grid grid-cols-2 gap-2 text-center mb-3">
                                <div class="bg-white rounded-lg p-2">
                                    <p class="text-xs text-gray-400">Tổng giá trị</p>
                                    <p class="text-xs font-bold text-gray-700">{{ number_format($ci['total_value']) }}đ</p>
                                </div>
                                <div class="bg-white rounded-lg p-2">
                                    <p class="text-xs text-gray-400">Phí nhận lớp (25%)</p>
                                    <p class="text-xs font-bold text-rose-500">-{{ number_format($ci['platform_fee']) }}đ</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-between pt-2 border-t border-gray-200">
                                <span class="text-xs text-gray-500">Thực nhận</span>
                                <span class="text-sm font-bold {{ $ci['status'] === 'active' ? 'text-green-600' : 'text-gray-800' }}">
                                    {{ number_format($ci['net_income']) }}đ
                                </span>
                            </div>
                        </div>
                    @endforeach

                    {{-- Total --}}
                    <div class="bg-green-50 rounded-xl p-4 flex items-center justify-between border border-green-100">
                        <span class="text-sm font-bold text-gray-700">
                            <i class="fas fa-calculator mr-1 text-green-600"></i> Tổng thực nhận
                        </span>
                        <span class="text-lg font-bold text-green-600">{{ number_format($totalNetIncome) }}đ</span>
                    </div>
                </div>
            @endif

        </div>


        {{-- Transaction History --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold text-gray-800">Lịch sử giao dịch</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Các giao dịch thanh toán gần đây</p>
                </div>
                <a href="{{ route('payment.history') }}"
                   class="text-xs font-semibold text-green-600 hover:text-green-700 transition flex items-center gap-1">
                    Xem tất cả <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            @if ($transactions->isEmpty())
                <div class="text-center py-14">
                    <i class="fas fa-receipt text-gray-300 text-4xl mb-3"></i>
                    <p class="text-gray-500 font-medium">Chưa có giao dịch nào</p>
                    <p class="text-gray-400 text-sm mt-1">Các giao dịch thanh toán sẽ hiển thị ở đây</p>
                </div>
            @else
                <div class="divide-y divide-gray-50">
                    @foreach ($transactions as $tx)
                        @php
                            $typeInfo = \App\Models\PaymentTransaction::TYPES[$tx->type] ?? null;
                            $sign = $typeInfo['sign'] ?? '';
                            $typeColor = $typeInfo['color'] ?? 'text-gray-600';
                            $typeLabel = $typeInfo['label'] ?? $tx->type;

                            $iconMap = [
                                'hold'   => 'fas fa-lock',
                                'charge' => 'fas fa-arrow-down',
                                'refund' => 'fas fa-arrow-up',
                            ];
                            $bgMap = [
                                'hold'   => 'bg-amber-100 text-amber-600',
                                'charge' => 'bg-red-100 text-red-500',
                                'refund' => 'bg-blue-100 text-blue-600',
                            ];
                        @endphp
                        <div class="px-5 py-4 flex items-center justify-between hover:bg-gray-50/50 transition">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg flex items-center justify-center {{ $bgMap[$tx->type] ?? 'bg-gray-100 text-gray-500' }}">
                                    <i class="{{ $iconMap[$tx->type] ?? 'fas fa-exchange-alt' }} text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">{{ $typeLabel }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5">
                                        {{ $tx->description ?? 'Giao dịch' }}
                                        <span class="mx-1">·</span>
                                        {{ $tx->created_at->format('d/m/Y H:i') }}
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold {{ $typeColor }}">
                                    {{ $sign }}{{ number_format($tx->amount) }}đ
                                </p>
                                <p class="text-[10px] text-gray-400 mt-0.5">
                                    @if ($tx->classRequest)
                                        {{ $tx->classRequest->subject->name ?? '' }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>

    </div>
@endsection
