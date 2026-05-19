@extends('layouts.admin')
@section('title', 'Thùng rác ngành học')
@section('content')
    <div class="bg-white p-6 rounded-2xl shadow-md">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">
                Danh sách ngành học đã xóa
            </h2>
        </div>

        <!-- TABLE -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">

                <thead>
                    <tr class="bg-gray-100 text-gray-600 uppercase text-sm">
                        <th class="p-3">Tên ngành học</th>
                        <th class="p-3">Thứ tự</th>
                        <th class="p-3 text-center">Khôi phục</th>
                        <th class="p-3 text-center">Xóa vĩnh viễn</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse ($grades as $grade)
                        <tr class="hover:bg-gray-50">

                            <td class="p-3">{{ $grade->name }}</td>
                            <td class="p-3">{{ $grade->sort_order ?? 'Chưa xác định' }}</td>

                            <!-- RESTORE -->
                            <td class="p-3 text-center">
                                <form action="{{ route('admin.grades.restore', $grade->id) }}" method="POST">
                                    @csrf
                                    <button class="text-green-600 hover:text-green-800 transition">
                                        <i class="fa-solid fa-rotate-left"></i>
                                    </button>
                                </form>
                            </td>

                            <!-- FORCE DELETE -->
                            <td class="p-3 text-center">
                                <form action="{{ route('admin.grades.forceDelete', $grade->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button onclick="return confirm('Xóa vĩnh viễn?')"
                                        class="text-red-600 hover:text-red-800 transition">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-6 text-center text-gray-500">
                                <div class="flex flex-col items-center gap-2">
                                    <i class="fa-solid fa-box-open text-3xl text-gray-400"></i>
                                    <span class="text-sm">
                                        Hiện tại chưa có ngành học nào trong thùng rác.
                                    </span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        <!-- FOOTER -->
        <div class="flex justify-between items-center mt-6">

            <a href="{{ route('admin.grades.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i>
                Quay lại
            </a>

            <div>
                {{ $grades->links() }}
            </div>

        </div>

    </div>
@endsection
