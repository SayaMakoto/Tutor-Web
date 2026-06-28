@extends('layouts.admin')
@section('title', 'Quản lý gia sư')

@section('content')

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-800">Quản lý gia sư</h1>
            <p class="text-sm text-gray-500 mt-0.5">Danh sách và trạng thái duyệt gia sư</p>
        </div>
        <div class="flex items-center gap-2 bg-violet-50 border border-violet-100 rounded-xl px-4 py-2">
            <i class="fas fa-chalkboard-teacher text-violet-500 text-sm"></i>
            <span class="text-sm font-semibold text-violet-700">{{ $tutors->total() }} gia sư</span>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Gia sư</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Trạng thái</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($tutors as $tutor)
                        <tr class="hover:bg-gray-50/70 transition">

                            {{-- Tutor info --}}
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $tutor->user->avatar
                                        ? asset('storage/' . $tutor->user->avatar)
                                        : 'https://ui-avatars.com/api/?name=' . urlencode($tutor->user->name) . '&background=7c3aed&color=fff' }}"
                                         class="w-9 h-9 rounded-full object-cover flex-shrink-0" alt="avatar">
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $tutor->user->name }}</p>
                                        <p class="text-xs text-gray-400">{{ $tutor->user->email }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Status --}}
                            <td class="px-5 py-3.5">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $tutor->status_color }}">
                                    <span class="w-1.5 h-1.5 rounded-full bg-current opacity-70"></span>
                                    {{ $tutor->status_label }}
                                </span>
                            </td>

                            {{-- Actions --}}
                            <td class="px-5 py-3.5 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.tutors.show', $tutor->id) }}"
                                       class="w-8 h-8 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center transition"
                                       title="Xem chi tiết">
                                        <i class="fas fa-eye text-xs"></i>
                                    </a>
                                    <button onclick="openModal({{ $tutor->id }}, '{{ $tutor->status }}')"
                                            class="w-8 h-8 bg-amber-50 hover:bg-amber-100 text-amber-600 rounded-lg flex items-center justify-center transition"
                                            title="Đổi trạng thái">
                                        <i class="fas fa-pencil text-xs"></i>
                                    </button>
                                    
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-5 py-12 text-center">
                                <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-chalkboard-teacher text-gray-300 text-xl"></i>
                                </div>
                                <p class="text-gray-500 font-medium text-sm">Chưa có gia sư nào</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($tutors->hasPages())
            <div class="px-5 py-3 border-t border-gray-100">
                {{ $tutors->links() }}
            </div>
        @endif
    </div>

    {{-- Status Modal --}}
    <div id="statusModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white w-full max-w-sm rounded-2xl shadow-2xl p-6" onclick="event.stopPropagation()">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 bg-violet-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-pen text-violet-600"></i>
                </div>
                <h3 class="text-base font-bold text-gray-800">Cập nhật trạng thái</h3>
            </div>

            <form id="statusForm" method="POST">
                @csrf
                @method('PUT')
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Trạng thái mới</label>
                <select name="status"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm mb-5
                               focus:ring-2 focus:ring-violet-400 focus:border-transparent focus:outline-none bg-white">
                    @foreach (\App\Models\Tutor::statusOptions() as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeModal()"
                            class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-sm font-semibold transition">
                        Huỷ
                    </button>
                    <button type="submit"
                            class="px-5 py-2.5 bg-gradient-to-r from-violet-600 to-indigo-600 text-white rounded-xl text-sm font-semibold hover:shadow-md transition">
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
        const form  = document.getElementById('statusForm');
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
    // Không dùng click-outside vì native <select> dropdown
    // sẽ fire click lên backdrop → đóng modal sai
    // Chỉ đóng qua nút Huỷ hoặc nút ×
</script>
@endpush
