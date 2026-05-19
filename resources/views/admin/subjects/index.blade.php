@extends('layouts.admin')
@section('title', 'Quản lý môn học')
@section('content')
    <div class="bg-white p-8 rounded-2xl shadow-sm">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-xl font-semibold text-gray-800">
                    Quản lý môn học
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Danh sách môn học trong hệ thống
                </p>
            </div>

            <div class="flex items-center gap-3">
                <x-admin.search />

                <a href="{{ route('admin.subjects.create') }}"
                    class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition shadow-sm">
                    + Thêm môn học
                </a>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto rounded-xl border">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-600 text-sm uppercase tracking-wide">
                    <tr>
                        <th class="p-4">Mã môn học</th>
                        <th class="p-4">Tên môn học</th>
                        <th class="p-4 text-center">Chi tiết</th>
                        <th class="p-4 text-center">Trạng thái</th>
                        <th class="p-4 text-center">Hành động</th>
                    </tr>
                </thead>

                <tbody class="divide-y text-gray-700">
                    @forelse ($subjects as $subject)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4 font-medium">
                                #{{ $subject->id }}
                            </td>

                            <td class="p-4">
                                {{ $subject->name }}
                            </td>
                            <td class="p-4 text-center">
                                <button type="button" onclick="openModal({{ $subject->id }})"
                                    class="text-gray-600 hover:text-blue-600 transition">
                                    Xem chi tiết
                                </button>
                            </td>
                            <td class="p-4 text-center">
                                <div class="inline-flex items-center">
                                    <x-admin.status :url="route('admin.subjects.toggleStatus', $subject->id)" :status="$subject->status" />
                                </div>
                            </td>

                            <td class="p-4">
                                <div class="flex justify-center items-center gap-3">

                                    <a href="{{ route('admin.subjects.edit', $subject->id) }}"
                                        class="text-blue-600 hover:text-blue-800 transition">
                                        <x-heroicon-s-pencil-square class="w-5 h-5" />
                                    </a>

                                    <form action="{{ route('admin.subjects.destroy', $subject->id) }}" method="POST"
                                        class="inline-flex items-center" onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 transition">
                                            <x-heroicon-s-trash class="w-5 h-5" />
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-gray-400">
                                Chưa có môn học nào
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer --}}
        <div class="flex items-center justify-between mt-6">

            <a href="{{ route('admin.subjects.trash') }}"
                class="text-sm text-red-600 hover:text-red-800 flex items-center gap-2">
                <x-heroicon-o-trash class="w-5 h-5" />
                Danh sách đã xóa
            </a>

            {{ $subjects->links() }}

        </div>

    </div>

    <!-- MODAL -->
    <div id="subjectModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
        <div class="bg-white w-105 rounded-2xl shadow-xl p-6 relative">

            <!-- Close -->
            <button onclick="closeModal()" class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 text-xl">
                ×
            </button>

            <h2 class="text-lg font-bold mb-4">Chi tiết môn học</h2>

            <div class="space-y-3 text-gray-700">

                <div>
                    <span class="font-semibold">Tên môn học:</span>
                    <span id="modalName"></span>
                </div>

                <div>
                    <span class="font-semibold">Ngành học:</span>
                    <ul id="modalGrades" class="list-disc ml-5 mt-1 text-sm text-gray-600"></ul>
                </div>

            </div>
        </div>
    </div>
@endsection

<script>
    const subjects = @json($subjects->items());

    function openModal(id) {
        const subject = subjects.find(s => s.id === id);

        document.getElementById('modalName').innerText = subject.name;

        const gradesList = document.getElementById('modalGrades');
        gradesList.innerHTML = '';

        if (subject.grades && subject.grades.length > 0) {
            subject.grades.forEach(g => {
                const li = document.createElement('li');
                li.innerText = g.name;
                gradesList.appendChild(li);
            });
        } else {
            gradesList.innerHTML = '<li>Chưa có ngành học</li>';
        }

        document.getElementById('subjectModal').classList.remove('hidden');
        document.getElementById('subjectModal').classList.add('flex');
    }

    function closeModal() {
        document.getElementById('subjectModal').classList.add('hidden');
        document.getElementById('subjectModal').classList.remove('flex');
    }
</script>
