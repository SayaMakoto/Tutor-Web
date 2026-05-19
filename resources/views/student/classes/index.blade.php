@php
    /** @var \Illuminate\Pagination\LengthAwarePaginator $classes */
@endphp

@extends('layouts.student')
@section('title', 'Danh sách lớp học')
@section('content')
    <div class="bg-white p-8 rounded-xl shadow mb-6">
        <h2 class="text-2xl font-bold mb-4">Tìm lớp học</h2>

        <form method="GET" action="{{ route('classes.index') }}" class="flex flex-wrap gap-4 items-end" id="filterForm">

            {{-- Mã lớp --}}
            <div>
                <label class="block mb-1 font-semibold">Mã lớp</label>
                <input type="text" name="id" value="{{ request('id') }}" placeholder="Nhập mã lớp"
                    class="border p-2 rounded-lg w-48">
            </div>

            {{-- Trạng thái --}}
            <div>
                <label class="block mb-1 font-semibold">Trạng thái</label>
                <select name="status" class="border p-2 rounded-lg w-48">
                    <option value="">Tất cả</option>

                    @foreach (\App\Models\ClassRequest::STATUSES as $value => $config)
                        <option value="{{ $value }}" {{ request('status') === $value ? 'selected' : '' }}>
                            {{ $config['label'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Hình thức học --}}
            <div>
                <label class="block mb-1 font-semibold">Hình thức học</label>
                <select name="study_type" class="border p-2 rounded-lg w-48">
                    <option value="">Tất cả</option>
                    <option value="online" {{ request('study_type') == 'online' ? 'selected' : '' }}>
                        Học trực tuyến
                    </option>
                    <option value="offline" {{ request('study_type') == 'offline' ? 'selected' : '' }}>
                        Học tại nhà
                    </option>
                </select>
            </div>

            {{-- Nút --}}
            <div class="flex gap-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Tìm kiếm
                </button>

                <a href="{{ route('classes.index') }}"
                    class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400">
                    Reset
                </a>
            </div>

        </form>
    </div>

    {{-- Danh sách lớp học --}}
    <div class="mb-10">
        <h2 class="text-2xl font-bold mb-6">Danh sách lớp học</h2>

        @if ($classes->count())
            <div class="grid md:grid-cols-3 gap-6">
                @foreach ($classes as $class)
                    <x-partials.class-card :classRequest="$class" />
                @endforeach
            </div>
        @else
            <p class="text-gray-500">Hiện chưa có lớp học nào.</p>
        @endif
    </div>

    <div class="mt-6">
        {{ $classes->links() }}
    </div>
@endsection


@push('scripts')
    <script>
        document.getElementById('filterForm').addEventListener('submit', function() {
            const inputs = this.querySelectorAll('input, select');

            inputs.forEach(input => {
                if (!input.value) {
                    input.removeAttribute('name');
                }
            });
        });
    </script>
@endpush
