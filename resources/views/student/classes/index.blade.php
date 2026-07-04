@php
    /** @var \Illuminate\Pagination\LengthAwarePaginator $classes */
@endphp

@extends($layout)
@section('title', 'Danh sách lớp học')

@section('content')

    {{-- Page Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-800">Danh sách lớp học</h1>
            <p class="text-sm text-gray-500 mt-0.5">Quản lý tất cả lớp bạn đã đăng</p>
        </div>
        <a href="{{ route('create-class.step1') }}"
            class="inline-flex items-center gap-2 bg-linear-to-r from-blue-600 to-indigo-600
                  text-white px-5 py-2.5 rounded-xl font-semibold text-sm shadow-sm
                  hover:shadow-md hover:from-blue-700 hover:to-indigo-700 transition-all">
            <i class="fas fa-plus"></i> Đăng lớp mới
        </a>
    </div>

    {{-- Bộ lọc --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-6">
        <form method="GET" action="{{ route('classes.index') }}" class="flex flex-wrap gap-3 items-end" id="filterForm">

            <div class="flex flex-col gap-1">
                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Mã lớp</label>
                <div class="relative">
                    <i class="fas fa-hashtag absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                    <input type="text" name="id" value="{{ request('id') }}" placeholder="Nhập mã lớp"
                        class="pl-8 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm
                                  focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:outline-none w-44">
                </div>
            </div>

            <div class="flex flex-col gap-1">
                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Trạng thái</label>
                <div class="relative">
                    <i class="fas fa-circle-half-stroke absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                    <select name="status"
                        class="pl-8 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm
                                   focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:outline-none w-44 bg-white appearance-none">
                        <option value="">Tất cả</option>
                        @foreach (\App\Models\ClassRequest::STATUSES as $value => $config)
                            <option value="{{ $value }}" {{ request('status') === $value ? 'selected' : '' }}>
                                {{ $config['label'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex flex-col gap-1">
                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Hình thức</label>
                <div class="relative">
                    <i class="fas fa-laptop absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                    <select name="study_type"
                        class="pl-8 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm
                                   focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:outline-none w-44 bg-white appearance-none">
                        <option value="">Tất cả</option>
                        <option value="online" {{ request('study_type') == 'online' ? 'selected' : '' }}>Trực tuyến
                        </option>
                        <option value="offline" {{ request('study_type') == 'offline' ? 'selected' : '' }}>Tại nhà</option>
                    </select>
                </div>
            </div>

            <div class="flex gap-2 items-end">
                <button type="submit"
                    class="inline-flex items-center gap-2 bg-blue-600 text-white
                               px-5 py-2.5 rounded-xl text-sm font-semibold
                               hover:bg-blue-700 transition">
                    <i class="fas fa-search text-xs"></i> Tìm kiếm
                </button>
                <a href="{{ route('classes.index') }}"
                    class="inline-flex items-center gap-2 bg-gray-100 text-gray-600
                          px-4 py-2.5 rounded-xl text-sm hover:bg-gray-200 transition">
                    <i class="fas fa-rotate-left text-xs"></i> Đặt lại
                </a>
            </div>

        </form>
    </div>

    {{-- Danh sách --}}
    @if ($classes->count())
        <div class="grid md:grid-cols-3 gap-5">
            @foreach ($classes as $class)
                <x-partials.class-card :classRequest="$class" />
            @endforeach
        </div>

        <div class="mt-6">
            {{ $classes->links() }}
        </div>
    @else
        <div class="text-center py-16 bg-white rounded-2xl border border-dashed border-gray-200">
            <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-folder-open text-gray-300 text-2xl"></i>
            </div>
            <p class="text-gray-500 font-medium">Không tìm thấy lớp học nào</p>
            <p class="text-gray-400 text-sm mt-1">Thử thay đổi bộ lọc hoặc đăng lớp mới</p>
            <a href="{{ route('create-class.step1') }}"
                class="mt-4 inline-flex items-center gap-2 bg-blue-600 text-white
                      px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-blue-700 transition">
                <i class="fas fa-plus"></i> Đăng lớp ngay
            </a>
        </div>
    @endif

@endsection

@push('scripts')
    <script>
        document.getElementById('filterForm').addEventListener('submit', function() {
        this.querySelectorAll('input, select').forEach(el => {
            if (!el.value) el.removeAttribute('name');
        });
        });
        });
    </script>
@endpush
