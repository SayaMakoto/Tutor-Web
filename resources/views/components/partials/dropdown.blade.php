<!-- Tạo id dựa trên name để tránh trùng -->
@php
    $dropdownId = $name . 'Dropdown';
    $menuId = $name . 'Menu';
    $selectedId = $name . 'Selected';
    $valueId = $name . 'Value';
@endphp

<div class="relative" id="{{ $dropdownId }}">
    <!-- Label -->
    <label class="block text-sm font-medium text-gray-600 mb-2">
        {{ $label }}
    </label>
    <!-- Button -->
    <button type="button" onclick="toggleDropdown('{{ $name }}')"
        class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-white text-left flex justify-between items-center focus:ring-2 focus:ring-blue-500">
        <span id="{{ $selectedId }}">Chọn {{ strtolower($label) }}</span>
        <span class="text-gray-400">▼</span>
    </button>
    <!-- Dropdown -->
    <div id="{{ $menuId }}" class="hidden absolute z-50 w-full bg-white border rounded-xl shadow-lg mt-2 p-3">
        <ul class="max-h-40 overflow-y-auto space-y-1">
            @foreach ($options as $option)
                <li onclick="selectOption('{{ $name }}','{{ $option }}')"
                    class="px-3 py-2 rounded-lg hover:bg-blue-100 cursor-pointer">
                    {{ $option }}
                </li>
            @endforeach
        </ul>
    </div>
    <!-- Hidden input -->
    <input type="hidden" name="{{ $name }}" id="{{ $valueId }}">
</div>
