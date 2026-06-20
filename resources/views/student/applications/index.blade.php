@extends('layouts.student')
@section('title', 'Lời mời từ gia sư')

@section('content')
    <div class="max-w-3xl mx-auto space-y-5">

        {{-- Page Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-envelope-open-text text-blue-600"></i> Lời mời từ gia sư
                </h1>
                <p class="text-sm text-gray-500 mt-0.5">Gia sư đã ứng tuyển và gửi lời mời cho lớp của bạn</p>
            </div>
            @if (!$applications->isEmpty())
                <div class="flex items-center gap-2 bg-blue-50 border border-blue-100 rounded-xl px-4 py-2">
                    <i class="fas fa-paper-plane text-blue-500 text-sm"></i>
                    <span class="text-sm font-semibold text-blue-700">{{ $applications->count() }} lời mời</span>
                </div>
            @endif
        </div>

        {{-- Tips --}}
        @if (!$applications->isEmpty())
            <div class="bg-amber-50 border border-amber-100 rounded-2xl p-4 flex items-start gap-3">
                <i class="fas fa-lightbulb text-amber-500 mt-0.5 flex-shrink-0"></i>
                <p class="text-amber-700 text-sm">
                    <strong>Gợi ý:</strong> Xem hồ sơ gia sư trước khi chấp nhận. Sau khi chọn, hệ thống sẽ
                    <strong>tạm khóa phí</strong> trong ví gia sư — Xu chỉ bị trừ thực tế sau bảo hành 7–15 ngày.
                </p>
            </div>
        @endif

        {{-- Applications --}}
        @if ($applications->isEmpty())
            <div class="text-center py-16 bg-white rounded-2xl border border-dashed border-gray-200">
                <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-envelope-open text-gray-300 text-2xl"></i>
                </div>
                <p class="text-gray-500 font-medium">Chưa có gia sư nào gửi lời mời</p>
                <p class="text-gray-400 text-sm mt-1">Khi gia sư ứng tuyển lớp của bạn, lời mời sẽ xuất hiện tại đây</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach ($applications as $app)
                    <x-application-card :app="$app" />
                @endforeach
            </div>
        @endif

    </div>
@endsection
