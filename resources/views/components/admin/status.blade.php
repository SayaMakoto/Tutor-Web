@props(['url', 'status' => 1])

<button type="button" onclick="toggleStatus(this)" data-url="{{ $url }}"
    class="{{ $status ? 'text-green-600' : 'text-gray-400' }} transition">
    <x-heroicon-s-eye class="w-5 h-5 eye-open {{ $status ? '' : 'hidden' }} pointer-events-none" />
    <x-heroicon-s-eye-slash class="w-5 h-5 eye-close {{ $status ? 'hidden' : '' }} pointer-events-none" />
</button>
