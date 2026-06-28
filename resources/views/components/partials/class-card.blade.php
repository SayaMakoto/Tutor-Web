@props(['classRequest', 'showDetail' => true, 'showCancel' => true, 'detailRoute' => null, 'cancelRoute' => null])

@php
    // Tên lớp học
    $className = $classRequest->subject?->name ?? 'Chưa xác định';

    // Mã lớp học
    $classCode = $classRequest->id;

    // Ngành học
    $gradeName = $classRequest->grade?->name ?? 'Chưa xác định';

    // Học phí
    $fee = $classRequest->fee ?? 0;

    // Địa chỉ
    $address = $classRequest->location ?? 'Chưa xác định';

    // Trạng thái
    $statusLabel = $classRequest->status_label;
    $statusColor = $classRequest->status_color;

    // URL chi tiết và hủy
    $detailUrl = $detailRoute ? route($detailRoute, $classRequest->id) : route('classes.show', $classRequest->id);
    $cancelUrl = $cancelRoute ? route($cancelRoute, $classRequest->id) : route('classes.destroy', $classRequest);

    // Quyền hiển thị nút Chi tiết và Hủy
    $isPaymentPending = $classRequest->status === 'payment_pending';
    $isCompleted = $classRequest->status === 'completed';
    $canCancel = $showCancel && !in_array($classRequest->status, ['cancelled', 'payment_pending', 'completed']);

    // Kiểm tra nếu lớp đã được giao cho tutor hiện tại
    $currentTutorId = auth()->user()->tutor?->id;
    $isAssignedToCurrentTutor = $classRequest->tutor_id === $currentTutorId && $classRequest->status === 'assigned';

    // Icon môn học theo tên môn học
    $iconMap = [
        'Toán' => 'fas fa-square-root-alt',
        'Văn' => 'fas fa-feather-alt',
        'Anh' => 'fas fa-language',
        'Lý' => 'fas fa-atom',
        'Hóa' => 'fas fa-flask',
        'Sinh' => 'fas fa-leaf',
        'Sử' => 'fas fa-landmark',
        'Địa' => 'fas fa-globe-asia',
        'Tin' => 'fas fa-laptop-code',
    ];
    $subjectKey = collect($iconMap)->keys()->first(fn($k) => str_contains($className, $k));
    $cardIcon = $iconMap[$subjectKey] ?? 'fas fa-book';
    $cardGradient = 'from-blue-500 to-blue-700';
@endphp

<div
    class="w-full bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden
            hover:shadow-lg hover:-translate-y-1 transition-all duration-200 relative flex flex-col">

    {{-- Header Card với Gradient --}}
    <div class="bg-linear-to-br {{ $cardGradient }} px-5 py-5 relative overflow-hidden">

        {{-- Decorative circle --}}
        <div class="absolute -top-4 -right-4 w-20 h-20 bg-white/10 rounded-full pointer-events-none"></div>

        {{-- Icon môn học --}}
        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mb-3">
            <i class="{{ $cardIcon }} text-white text-lg"></i>
        </div>

        {{-- Tên + mã lớp --}}
        <h3 class="text-white font-bold text-base leading-snug">
            {{ $className }}
        </h3>
        <p class="text-white/70 text-xs mt-0.5">Mã lớp: #{{ $classCode }}</p>

        {{-- Badge trạng thái --}}
        <div class="absolute top-3 right-3 px-2.5 py-1 text-xs font-semibold rounded-full {{ $statusColor }} shadow-sm">
            {{ $statusLabel }}
        </div>
    </div>

    {{-- Body Card --}}
    <div class="px-5 py-4 flex-1 flex flex-col gap-2">
        <div class="flex items-center gap-2 text-sm text-gray-600">
            <i class="fas fa-layer-group w-4 text-center text-indigo-400"></i>
            <span>{{ $gradeName }}</span>
        </div>
        <div class="flex items-center gap-2 text-sm text-gray-600">
            <i class="fas fa-map-marker-alt w-4 text-center text-rose-400"></i>
            <span class="truncate">{{ $address }}</span>
        </div>
        <div class="flex items-center gap-2 text-sm font-semibold text-blue-600">
            <i class="fas fa-dollar-sign w-4 text-center text-blue-400"></i>
            <span>{{ number_format($fee) }} VNĐ / 1h</span>
        </div>
    </div>

    {{-- Footer Card — Nút hành động --}}
    @if ($showDetail || $showCancel)
        <div class="px-5 py-3 border-t border-gray-100 flex justify-between items-center gap-2">

            {{-- Chi tiết --}}
            @if ($showDetail)
                <a href="{{ $detailUrl }}"
                    class="flex-1 text-center px-4 py-2 bg-blue-600 text-white rounded-xl 
                          hover:bg-blue-700 text-sm font-semibold transition-colors duration-150">
                    <i class="fas fa-eye mr-1"></i> Chi tiết
                </a>
            @endif

            {{-- Nếu lớp đã được giao cho gia sư hiện tại --}}
            @if ($isAssignedToCurrentTutor)
                <a href="#"
                    class="flex-1 text-center px-4 py-2 bg-indigo-600 text-white rounded-xl 
                          hover:bg-indigo-700 text-sm font-semibold transition-colors duration-150">
                    <i class="fas fa-calendar-alt mr-1"></i> Lịch dạy
                </a>

                {{-- Nếu đang chờ thanh toán --}}
            @elseif ($isPaymentPending)
                <a href="#"
                    class="flex-1 text-center px-4 py-2 bg-emerald-600 text-white rounded-xl 
                          hover:bg-emerald-700 text-sm font-semibold transition-colors duration-150">
                    <i class="fas fa-credit-card mr-1"></i> Thanh toán
                </a>

                {{-- Nếu được phép hủy --}}
            @elseif ($canCancel)
                <form action="{{ $cancelUrl }}" method="POST"
                    onsubmit="return confirm('Bạn có chắc muốn hủy lớp này?');" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full px-4 py-2 bg-red-50 text-red-600 border border-red-200 rounded-xl 
                                   hover:bg-red-600 hover:text-white text-sm font-semibold transition-all duration-150">
                        <i class="fas fa-times mr-1"></i> Hủy lớp
                    </button>
                </form>
            @endif

        </div>
    @endif

</div>
