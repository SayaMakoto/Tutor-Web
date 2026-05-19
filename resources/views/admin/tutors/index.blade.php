@extends('layouts.admin')
@section('title', 'Quản lý gia sư')
@section('content')
    <x-alert type="success" :message="session('success')" />
    <x-alert type="error" :message="$errors->first()" />

    <div class="bg-white p-6 rounded-2xl shadow-md">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Quản lý gia sư</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 uppercase text-sm">
                        <th class="p-3">Mã gia sư</th>
                        <th class="p-3">Tên gia sư</th>
                        <th class="p-3">Xem chi tiết</th>
                        <th class="p-3">Trạng thái</th>
                        <th class="p-3 text-center">Hành động</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @foreach ($tutors as $tutor)
                        <tr class="hover:bg-gray-50">

                            <td class="p-3">{{ $tutor->id }}</td>

                            <td class="p-3">
                                {{ $tutor->user->name }}
                            </td>

                            <td class="p-3">
                                <a href="{{ route('admin.tutors.show', $tutor->id) }}"
                                    class="text-blue-500 hover:text-blue-700">
                                    Xem chi tiết
                                </a>
                            </td>

                            <td class="p-3">
                                <span class="px-2 py-1 rounded-full text-xs {{ $tutor->status_color }}">
                                    {{ $tutor->status_label }}
                                </span>
                            </td>

                            <td class="p-3 text-center">
                                <button onclick="openModal({{ $tutor->id }}, '{{ $tutor->status }}')"
                                    class="text-yellow-500 hover:scale-110 transition">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-6">
                {{ $tutors->links() }}
            </div>
        </div>
    </div>


    {{-- Modal --}}
    <div id="statusModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
        <div class="bg-white w-96 p-6 rounded-xl shadow-lg">
            <h3 class="text-lg font-semibold mb-4">Cập nhật trạng thái</h3>

            <form id="statusForm" method="POST">
                @csrf
                @method('PUT')

                <select name="status" class="w-full border rounded-lg p-2 mb-4">
                    @foreach (\App\Models\Tutor::statusOptions() as $key => $label)
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

        form.action = `/admin/tutors/${id}`;
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
