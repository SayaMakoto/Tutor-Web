@extends('layouts.admin')
@section('title', 'Quản lý môn học')

@section('content')

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-800">Quản lý môn học</h1>
            <p class="text-sm text-gray-500 mt-0.5">Danh sách môn học trong hệ thống</p>
        </div>
        <div class="flex items-center gap-2">
            <x-admin.search />
            <a href="{{ route('admin.subjects.create') }}"
               class="flex items-center gap-2 bg-gradient-to-r from-violet-600 to-indigo-600
                      text-white px-4 py-2.5 rounded-xl text-sm font-semibold hover:shadow-md transition">
                <i class="fas fa-plus text-xs"></i> Thêm môn học
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Môn học</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Trạng thái</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Chi tiết</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($subjects as $subject)
                        <tr class="hover:bg-gray-50/70 transition">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-violet-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-book text-violet-500 text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $subject->name }}</p>
                                        <p class="text-xs text-gray-400">ID #{{ $subject->id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                <x-admin.status :url="route('admin.subjects.toggleStatus', $subject->id)" :status="$subject->status" />
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                <button type="button" onclick="openModal({{ $subject->id }})"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg text-xs font-semibold transition">
                                    <i class="fas fa-eye text-xs"></i> Chi tiết
                                </button>
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.subjects.edit', $subject->id) }}"
                                       class="w-8 h-8 bg-amber-50 hover:bg-amber-100 text-amber-600 rounded-lg flex items-center justify-center transition"
                                       title="Sửa">
                                        <i class="fas fa-pencil text-xs"></i>
                                    </a>
                                    <form action="{{ route('admin.subjects.destroy', $subject->id) }}" method="POST"
                                          onsubmit="return confirm('Bạn có chắc muốn xóa?')">
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
                                    <i class="fas fa-book text-gray-300 text-xl"></i>
                                </div>
                                <p class="text-gray-500 font-medium text-sm">Chưa có môn học nào</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-5 py-3.5 border-t border-gray-100 flex items-center justify-between gap-4">
            <a href="{{ route('admin.subjects.trash') }}"
               class="flex items-center gap-2 text-sm text-red-500 hover:text-red-700 font-medium transition">
                <i class="fas fa-trash-can text-xs"></i> Danh sách đã xóa
            </a>
            {{ $subjects->links() }}
        </div>
    </div>

    {{-- Detail Modal --}}
    <div id="subjectModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white w-full max-w-sm rounded-2xl shadow-2xl p-6">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-violet-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-book text-violet-600"></i>
                    </div>
                    <h3 class="font-bold text-gray-800">Chi tiết môn học</h3>
                </div>
                <button onclick="closeModal()" class="w-7 h-7 bg-gray-100 hover:bg-gray-200 rounded-lg flex items-center justify-center transition text-gray-500">
                    <i class="fas fa-times text-xs"></i>
                </button>
            </div>

            <div class="space-y-3">
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Tên môn học</p>
                    <p id="modalName" class="font-semibold text-gray-800"></p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-1.5">Ngành học liên quan</p>
                    <ul id="modalGrades" class="space-y-1 text-sm text-gray-600"></ul>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    const subjects = @json($subjects->items());

    function openModal(id) {
        const subject    = subjects.find(s => s.id === id);
        const gradesList = document.getElementById('modalGrades');
        document.getElementById('modalName').innerText = subject.name;
        gradesList.innerHTML = '';
        if (subject.grades && subject.grades.length > 0) {
            subject.grades.forEach(g => {
                gradesList.innerHTML += `<li class="flex items-center gap-1.5 text-xs"><i class="fas fa-layer-group text-violet-400"></i>${g.name}</li>`;
            });
        } else {
            gradesList.innerHTML = '<li class="text-gray-400 text-xs">Chưa có ngành học</li>';
        }
        document.getElementById('subjectModal').classList.replace('hidden','flex');
    }

    function closeModal() {
        document.getElementById('subjectModal').classList.replace('flex','hidden');
    }

    document.getElementById('subjectModal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });
</script>
@endpush
