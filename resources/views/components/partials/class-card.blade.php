@props(['classRequest', 'showDetail' => true, 'showCancel' => true, 'detailRoute' => null, 'cancelRoute' => null])

@php
    // Tên lớp học
    $className = $classRequest->subject?->name ?? ($classRequest->subject_request ?? 'Chưa xác định');

    // Mã lớp học
    $classCode = $classRequest->id;

    // Ngành học
    $gradeName = $classRequest->grade?->name ?? ($classRequest->grade_request ?? 'Chưa xác định');

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
@endphp

<div
    class="bg-white rounded-2xl shadow-md overflow-hidden relative w-96 hover:shadow-lg hover:border hover:border-blue-500 transition">

    {{-- Thông báo trạng thái góc trên bên phải --}}
    <div class="absolute top-3 right-3 px-3 py-1 text-xs font-semibold rounded-full {{ $statusColor }}">
        {{ $statusLabel }}
    </div>

    {{-- Hình chữ nhật (placeholder) --}}
    <div class="h-40 bg-gray-100 flex flex-col justify-center items-start p-4">
        <h3 class="text-lg font-semibold text-gray-800">
            {{ $className }} - Mã: {{ $classCode }}
        </h3>
        <p class="text-sm text-gray-600 mt-1">
            Ngành học: {{ $gradeName }}
        </p>
        <p class="text-sm text-gray-600 mt-1">
            Học phí: <span class="font-semibold text-blue-600">{{ number_format($fee) }} VNĐ/1h</span>
        </p>
        <p class="text-sm text-gray-600 mt-1">
            Địa chỉ: {{ $address }}
        </p>
    </div>

    {{-- Nút Chi tiết + Hủy --}}
    @if ($showDetail || $showCancel)
        <div class="flex justify-between p-4 border-t">

            {{-- Chi tiết --}}
            @if ($showDetail)
                <a href="{{ $detailUrl }}"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium">
                    Chi tiết
                </a>
            @endif

            {{-- Nếu lớp đã được giao cho gia sư hiện tại --}}
            @if ($isAssignedToCurrentTutor)
                <a href="#"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm font-medium">
                    Lịch dạy
                </a>

                {{-- Nếu đang chờ thanh toán --}}
            @elseif ($isPaymentPending)
                <a href="#"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm font-medium">
                    Thanh toán
                </a>

                {{-- Nếu được phép hủy --}}
            @elseif ($canCancel)
                <form action="{{ $cancelUrl }}" method="POST"
                    onsubmit="return confirm('Bạn có chắc muốn hủy lớp này?');">
                    @csrf
                    @method('DELETE')

                    <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm font-medium">
                        Hủy
                    </button>
                </form>
            @endif

        </div>
    @endif
</div>
