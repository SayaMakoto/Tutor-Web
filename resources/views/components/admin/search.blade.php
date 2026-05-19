@props([
    'placeholder' => 'Tìm kiếm...',
    'inputId' => 'searchInput',
])

<form method="GET" class="relative flex items-center">

    {{-- Giữ lại status nếu đang lọc --}}
    @if (request('status'))
        <input type="hidden" name="status" value="{{ request('status') }}">
    @endif

    <input name="keyword" id="{{ $inputId }}" value="{{ request('keyword') }}" type="text"
        placeholder="{{ $placeholder }}" onkeydown="if(event.key === 'Enter'){ this.form.submit(); }"
        class="w-0 opacity-0 transition-all duration-300 px-4 py-2 border rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500">

    <button type="button" onclick="toggleSearch('{{ $inputId }}')"
        class="bg-gray-200 px-4 py-2 rounded-lg hover:bg-gray-300">
        <x-heroicon-s-magnifying-glass class="w-5 h-5 mx-auto" />
    </button>

</form>

<script>
    function toggleSearch(id) {
        const input = document.getElementById(id);

        if (input.classList.contains('w-0')) {
            input.classList.remove('w-0', 'opacity-0');
            input.classList.add('w-64', 'opacity-100');
            input.focus();
        } else {
            input.closest('form').submit();
        }
    }
</script>
