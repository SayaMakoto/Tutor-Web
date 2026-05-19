@props([
    'type' => 'success',
    'message' => null,
])

@php
    $colors = [
        'success' => 'bg-green-100 border-green-400 text-green-700',
        'error' => 'bg-red-100 border-red-400 text-red-700',
        'warning' => 'bg-yellow-100 border-yellow-400 text-yellow-700',
        'info' => 'bg-blue-100 border-blue-400 text-blue-700',
    ];

    $icons = [
        'success' => 'check-circle',
        'error' => 'x-circle',
        'warning' => 'exclamation-triangle',
        'info' => 'information-circle',
    ];
@endphp

{{-- Session message --}}
@if ($message)
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition.opacity.duration.500ms
        class="fixed top-6 left-1/2 -translate-x-1/2 
                flex items-center gap-3
                px-6 py-3 
                border rounded-xl shadow-lg 
                z-50
                {{ $colors[$type] ?? $colors['info'] }}">

        <x-dynamic-component :component="'heroicon-o-' . ($icons[$type] ?? 'information-circle')" class="w-5 h-5" />

        <span class="text-sm font-medium">
            {{ $message }}
        </span>
    </div>
@endif


{{-- Validation errors --}}
@if ($errors->any())
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" x-transition.opacity.duration.500ms
        class="fixed top-6 left-1/2 -translate-x-1/2 
                flex flex-col gap-2
                px-6 py-4 
                border rounded-xl shadow-lg 
                z-50
                {{ $colors['error'] }}">

        <div class="flex items-center gap-2">
            <x-dynamic-component component="heroicon-o-x-circle" class="w-5 h-5" />
            <span class="font-semibold text-sm">
                Có lỗi xảy ra:
            </span>
        </div>

        <ul class="text-sm list-disc list-inside space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
