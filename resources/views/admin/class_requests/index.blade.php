@extends('layouts.admin')
@section('title', 'Quản lý đơn đăng lớp')

@section('content')

    {{-- Header --}}
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-800">Đơn đăng lớp học</h1>
            <p class="text-sm text-gray-500 mt-0.5">Quản lý và duyệt yêu cầu mở lớp từ học viên</p>
        </div>

        {{-- Filters --}}
        <div class="flex flex-wrap items-center gap-2">
            <form method="GET" class="flex items-center gap-2">
                <div class="relative">
                    <i
                        class="fas fa-filter absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
                    <select name="status" onchange="this.form.submit()"
                        class="pl-8 pr-4 py-2 border border-gray-200 rounded-xl text-sm bg-white
                                   focus:ring-2 focus:ring-violet-400 focus:border-transparent focus:outline-none appearance-none">
                        <option value="">Tất cả trạng thái</option>
                        @foreach (\App\Models\ClassRequest::statusOptions() as $key => $label)
                            <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                                {{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                @if (request('keyword'))
                    <input type="hidden" name="keyword" value="{{ request('keyword') }}">
                @endif
            </form>

            <x-admin.search placeholder="Tìm theo mã lớp" inputId="searchInput" />

            @if (request()->has('keyword') || request()->has('status'))
                <a href="{{ route('admin.class-requests.index') }}"
                    class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl text-sm font-medium transition flex items-center gap-1.5">
                    <i class="fas fa-rotate-left text-xs"></i> Reset
                </a>
            @endif
        </div>
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Mã</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Học viên</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Trạng thái</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">
                            Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($classRequests as $classRequest)
                        <tr class="hover:bg-gray-50/70 transition">

                            <td class="px-5 py-3.5">
                                <span
                                    class="font-mono text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-lg">#{{ $classRequest->id }}</span>
                            </td>

                            <td class="px-5 py-3.5 font-medium text-gray-800">
                                {{ $classRequest->student_name }}
                            </td>

                            <td class="px-5 py-3.5">
                                <span
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $classRequest->status_color }}">
                                    <span class="w-1.5 h-1.5 rounded-full bg-current opacity-70"></span>
                                    {{ $classRequest->status_label }}
                                </span>
                            </td>

                            <td class="px-5 py-3.5">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.class-requests.show', $classRequest->id) }}"
                                        class="w-8 h-8 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center transition"
                                        title="Xem chi tiết">
                                        <i class="fas fa-eye text-xs"></i>
                                    </a>
                                    <button onclick="openModal({{ $classRequest->id }}, '{{ $classRequest->status }}')"
                                        class="w-8 h-8 bg-amber-50 hover:bg-amber-100 text-amber-600 rounded-lg flex items-center justify-center transition"
                                        title="Đổi trạng thái">
                                        <i class="fas fa-pencil text-xs"></i>
                                    </button>
                                    <form action="{{ route('admin.class-requests.destroy', $classRequest->id) }}"
                                        method="POST" onsubmit="return confirm('Bạn chắc chắn muốn xoá lớp này?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="w-8 h-8 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg flex items-center justify-center transition"
                                            title="Xoá">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-12 text-center">
                                <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-folder-open text-gray-300 text-xl"></i>
                                </div>
                                <p class="text-gray-500 font-medium text-sm">Không tìm thấy đơn đăng lớp nào</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer --}}
        <div class="px-5 py-3.5 border-t border-gray-100 flex items-center justify-between gap-4">
            <a href="{{ route('admin.class-requests.trash') }}"
                class="flex items-center gap-2 text-sm text-red-500 hover:text-red-700 font-medium transition">
                <i class="fas fa-trash-can text-xs"></i> Danh sách đã xoá
            </a>
            {{ $classRequests->links() }}
        </div>
    </div>

    {{-- Status Modal --}}
    <div id="statusModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white w-full max-w-sm rounded-2xl shadow-2xl p-6" onclick="event.stopPropagation()">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 bg-violet-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-pen text-violet-600"></i>
                </div>
                <h3 class="text-base font-bold text-gray-800">Cập nhật trạng thái lớp</h3>
            </div>

            <form id="statusForm" method="POST">
                @csrf @method('PUT')
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Trạng thái mới</label>
                <select name="status"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm mb-5
                               focus:ring-2 focus:ring-violet-400 focus:border-transparent focus:outline-none bg-white">
                    @foreach (\App\Models\ClassRequest::statusOptions() as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeModal()"
                        class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-sm font-semibold transition">
                        Huỷ
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 bg-linear-to-r from-violet-600 to-indigo-600 text-white rounded-xl text-sm font-semibold hover:shadow-md transition">
                        Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        function openModal(id, currentStatus) {
            const modal = document.getElementById('statusModal');
            const form = document.getElementById('statusForm');
            form.action = `/admin/class-requests/${id}`;
            form.querySelector('select').value = currentStatus;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal() {
            document.getElementById('statusModal').classList.replace('flex', 'hidden');
        }
        // Không dùng click-outside — native select sẽ fire click sai lên backdrop
    </script>
@endpush
