@extends('layouts.admin')
@section('title', 'Quản lý Đơn đăng lớp')
@section('content')
    <x-alert type="success" :message="session('success')" />
    <x-alert type="error" :message="$errors->first()" />
    <div class="bg-white p-6 rounded-2xl shadow-md">

        <div class="flex justify-between items-center mb-6">

            <h2 class="text-2xl font-bold text-gray-800">
                Danh sách yêu cầu mở lớp
            </h2>

            <div class="flex items-center gap-3">

                {{-- FILTER STATUS --}}
                <form method="GET" class="flex items-center gap-2">

                    <select name="status" onchange="this.form.submit()" class="border rounded-lg px-3 py-2 text-sm">

                        <option value="">-- Tất cả trạng thái --</option>

                        @foreach (\App\Models\ClassRequest::statusOptions() as $key => $label)
                            <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>

                    {{-- giữ keyword nếu có --}}
                    @if (request('keyword'))
                        <input type="hidden" name="keyword" value="{{ request('keyword') }}">
                    @endif

                </form>

                {{-- SEARCH --}}
                <x-admin.search placeholder="Tìm theo mã, tên lớp, khối, môn..." inputId="searchInput" />

                {{-- RESET --}}
                @if (request()->has('keyword') || request()->has('status'))
                    <a href="{{ route('admin.class-requests.index') }}"
                        class="px-4 py-2 bg-gray-200 rounded-lg text-sm hover:bg-gray-300 transition">
                        Reset
                    </a>
                @endif

            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">

                <thead>
                    <tr class="bg-gray-100 text-gray-600 uppercase text-sm">
                        <th class="p-3">Mã yêu cầu</th>
                        <th class="p-3">Tên người yêu cầu</th>
                        <th class="p-3">Xem chi tiết</th>
                        <th class="p-3">Trạng thái</th>
                        <th class="p-3 text-center">Hành động</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @foreach ($classRequests as $classRequest)
                        <tr class="hover:bg-gray-50">

                            <td class="p-3">{{ $classRequest->id }}</td>
                            <td class="p-3">{{ $classRequest->student_name }}</td>
                            <td class="p-3">
                                <a href="{{ route('admin.class-requests.show', $classRequest->id) }}"
                                    class="text-blue-500 hover:text-blue-700">
                                    Xem chi tiết
                                </a>
                            </td>
                            <td class="p-3">
                                <span class="px-2 py-1 rounded-full text-xs {{ $classRequest->status_color }}">
                                    {{ $classRequest->status_label }}
                                </span>
                            </td>
                            <td class="p-3 text-center flex justify-center gap-3">
                                <!-- EDIT -->
                                <button onclick="openModal({{ $classRequest->id }}, '{{ $classRequest->status }}')"
                                    class="text-yellow-500 hover:scale-110 transition">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <!-- DELETE -->
                                <form action="{{ route('admin.class-requests.destroy', $classRequest->id) }}"
                                    method="POST" onsubmit="return confirm('Bạn chắc chắn muốn xoá lớp này?');">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="text-red-500 hover:scale-110 transition">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>

                        </tr>
                    @endforeach
                </tbody>

            </table>
            <div class="flex items-center justify-between mt-6">

                <a href="{{ route('admin.class-requests.trash') }}"
                    class="text-sm text-red-600 hover:text-red-800 flex items-center gap-2">
                    <x-heroicon-o-trash class="w-5 h-5" />
                    Danh sách đã xoá
                </a>

                {{ $classRequests->links() }}

            </div>
        </div>


    </div>

    <div id="statusModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">

        <div class="bg-white w-96 p-6 rounded-xl shadow-lg">
            <h3 class="text-lg font-semibold mb-4">Cập nhật trạng thái</h3>

            <form id="statusForm" method="POST">
                @csrf
                @method('PUT')

                <select name="status" class="w-full border rounded-lg p-2 mb-4">

                    @foreach (\App\Models\ClassRequest::statusOptions() as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach

                </select>

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-200 rounded-lg">
                        Huỷ
                    </button>

                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                        Lưu
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

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
        const modal = document.getElementById('statusModal');
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }
</script>
