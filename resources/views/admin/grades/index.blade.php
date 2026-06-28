@extends('layouts.admin')
@section('title', 'Quản lý ngành học')

@section('content')

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-800">Quản lý ngành học</h1>
            <p class="text-sm text-gray-500 mt-0.5">Danh sách ngành học trong hệ thống</p>
        </div>
        <div class="flex items-center gap-2">
            <x-admin.search />
            <a href="{{ route('admin.grades.create') }}"
               class="flex items-center gap-2 bg-gradient-to-r from-violet-600 to-indigo-600
                      text-white px-4 py-2.5 rounded-xl text-sm font-semibold hover:shadow-md transition">
                <i class="fas fa-plus text-xs"></i> Thêm ngành học
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Ngành học</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Thứ tự</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Trạng thái</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($grades as $grade)
                        <tr class="hover:bg-gray-50/70 transition">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-indigo-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-layer-group text-indigo-500 text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $grade->name }}</p>
                                        <p class="text-xs text-gray-400">ID #{{ $grade->id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                <span class="inline-flex items-center justify-center w-7 h-7 bg-gray-100 rounded-lg text-xs font-bold text-gray-600">
                                    {{ $grade->sort_order ?? '—' }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                <div class="inline-flex items-center">
                                    <x-admin.status :url="route('admin.grades.toggleStatus', $grade->id)" :status="$grade->status" />
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.grades.edit', $grade->id) }}"
                                       class="w-8 h-8 bg-amber-50 hover:bg-amber-100 text-amber-600 rounded-lg flex items-center justify-center transition"
                                       title="Sửa">
                                        <i class="fas fa-pencil text-xs"></i>
                                    </a>
                                    <form action="{{ route('admin.grades.destroy', $grade->id) }}" method="POST"
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
                                    <i class="fas fa-layer-group text-gray-300 text-xl"></i>
                                </div>
                                <p class="text-gray-500 font-medium text-sm">Chưa có ngành học nào</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-5 py-3.5 border-t border-gray-100 flex items-center justify-between gap-4">
            <a href="{{ route('admin.grades.trash') }}"
               class="flex items-center gap-2 text-sm text-red-500 hover:text-red-700 font-medium transition">
                <i class="fas fa-trash-can text-xs"></i> Danh sách đã xóa
            </a>
            {{ $grades->links() }}
        </div>
    </div>

@endsection
