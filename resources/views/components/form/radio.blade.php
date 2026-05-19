@props(['name', 'label' => '', 'value', 'checked' => false, 'class' => ''])

<label class="flex items-center gap-3 cursor-pointer">
    <input type="radio" name="{{ $name }}" value="{{ $value }}" {{ $checked ? 'checked' : '' }}
        {{ $attributes->merge([
            'class' => 'w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300 ' . $class,
        ]) }}>

    <span class="text-gray-700">
        {{ $label }}
    </span>
</label>
