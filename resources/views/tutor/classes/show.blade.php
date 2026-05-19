@extends('layouts.tutor')
@section('title', 'Chi tiết lớp #' . $class->id)
@section('content')
    @php
        $subjectName = $class->subject?->name ?? ($class->subject_request ?? 'Chưa xác định');
        $gradeName = $class->grade?->name ?? ($class->grade_request ?? 'Chưa xác định');

        $currentWeek = 1;

        $days = ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'Chủ nhật'];

        $scheduleArr = $class->schedule ? explode(',', $class->schedule) : [];
        $scheduleArr = array_map('trim', $scheduleArr);

        $timeValue = $class->time ?? '—';
    @endphp

    <div class="bg-white p-8 rounded-xl shadow">

        {{-- Tiêu đề --}}
        <h2 class="text-2xl font-bold mb-6">
            Chi tiết lớp #{{ $class->id }}
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Thông tin lớp --}}
            <div class="space-y-3">

                <p><strong>📘 Môn học:</strong> {{ $subjectName }}</p>

                <p><strong>🏫 Ngành học:</strong> {{ $gradeName }}</p>

                <p><strong>📍 Địa chỉ:</strong> {{ $class->location ?? 'Chưa xác định' }}</p>

                <p><strong>ℹ️ Trạng thái:</strong> {{ $class->status_label }}</p>

                <p><strong>💰 Học phí:</strong> {{ number_format($class->fee ?? 0) }} VNĐ/giờ</p>

            </div>

            {{-- Action cho tutor --}}
            @if ($class->status !== 'assigned')
                {{-- Action cho tutor --}}
                <div class="space-y-4">

                    <h3 class="text-xl font-semibold">Hành động</h3>

                    <p class="text-gray-600 text-sm">
                        Bạn có thể gửi lời mời đến học viên để nhận lớp này.
                    </p>

                    <form action="{{ route('tutor.classes.invite', $class->id) }}" method="POST">
                        @csrf

                        <button type="button" onclick="document.getElementById('inviteModal').classList.remove('hidden')"
                            class="px-5 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                            📩 Gửi lời mời cho học viên
                        </button>
                    </form>

                </div>
            @endif

        </div>
    </div>

    {{-- Thời khóa biểu --}}
    <div class="bg-white p-8 rounded-xl shadow mt-6">

        <h3 class="text-xl font-bold mb-4">Thời khóa biểu</h3>

        <div class="flex items-center justify-center mb-4 gap-4">
            <button class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">Tuần trước</button>
            <span>Tuần {{ $currentWeek }}/{{ $class->weeks ?? 1 }}</span>
            <button class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">Tuần sau</button>
        </div>

        <div class="grid grid-cols-7 gap-2 text-center">
            @foreach ($days as $day)
                @php
                    $dayCode = match ($day) {
                        'Thứ 2' => 'T2',
                        'Thứ 3' => 'T3',
                        'Thứ 4' => 'T4',
                        'Thứ 5' => 'T5',
                        'Thứ 6' => 'T6',
                        'Thứ 7' => 'T7',
                        'Chủ nhật' => 'CN',
                    };

                    $isScheduled = in_array($dayCode, $scheduleArr);
                @endphp

                <div class="border rounded-lg p-2 min-h-15">
                    <div class="font-semibold">{{ $day }}</div>
                    <div class="text-sm mt-1 {{ $isScheduled ? 'text-blue-600' : 'text-gray-400' }}">
                        {{ $isScheduled ? $timeValue : '—' }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- quay lại --}}
    <div class="flex justify-center mt-4">
        <a href="{{ url()->previous() ?? route('tutor.classes.index') }}"
            class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 transition">
            ← Quay lại
        </a>
    </div>

    @if ($class->status !== 'assigned')
        <div id="inviteModal" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center">

            <div class="bg-white w-full max-w-md rounded-xl p-6 shadow-lg">

                <form method="POST" action="{{ route('tutor.classes.invite', $class->id) }}">
                    @csrf

                    <h2 class="text-xl font-bold mb-4">
                        Gửi lời mời cho học viên
                    </h2>

                    <textarea name="message" rows="4" class="w-full border rounded-lg p-3 text-sm" placeholder="Viết lời nhắn..."></textarea>

                    <div class="flex justify-end gap-2 mt-4">

                        <button type="button" onclick="document.getElementById('inviteModal').classList.add('hidden')"
                            class="px-4 py-2 bg-gray-200 rounded-lg">
                            Hủy
                        </button>

                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Gửi lời mời
                        </button>

                    </div>

                </form>

            </div>
        </div>
    @endif
    <script>
        const modal = document.getElementById('inviteModal');

        function openModal() {
            modal.classList.remove('hidden');
        }

        function closeModal() {
            modal.classList.add('hidden');
        }

        window.onclick = function(e) {
            const modal = document.getElementById('inviteModal');
            if (e.target === modal) modal.classList.add('hidden');
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.getElementById('inviteModal').classList.add('hidden');
            }
        });
    </script>
@endsection
