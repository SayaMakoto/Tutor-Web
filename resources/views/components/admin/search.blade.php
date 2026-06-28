@props([
    'placeholder' => 'Tìm kiếm...',
    'inputId'     => 'searchInput',
])

<form method="GET" class="flex items-center gap-1">

    {{-- Giữ lại filter nếu đang lọc --}}
    @if(request('status'))
        <input type="hidden" name="status" value="{{ request('status') }}">
    @endif

    <div class="relative">
        <i class="fas fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
        <input name="keyword" id="{{ $inputId }}"
               value="{{ request('keyword') }}" type="text"
               placeholder="{{ $placeholder }}"
               onkeydown="if(event.key === 'Enter'){ this.form.submit(); }"
               class="w-56 pl-9 pr-4 py-2 border border-gray-200 rounded-xl text-sm bg-white
                      focus:ring-2 focus:ring-violet-400 focus:border-transparent focus:outline-none
                      placeholder-gray-400 transition">
    </div>

    <button type="submit"
            class="w-9 h-9 bg-violet-50 hover:bg-violet-100 text-violet-600 rounded-xl flex items-center justify-center transition"
            title="Tìm">
        <i class="fas fa-search text-xs"></i>
    </button>

</form>
