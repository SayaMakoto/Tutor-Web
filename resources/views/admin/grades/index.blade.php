@extends('layouts.admin')
@section('title', 'Quản lý ngành học')
@section('content')
    <div class="bg-white p-8 rounded-2xl shadow-sm">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-xl font-semibold text-gray-800">
                    Quản lý ngành học
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Danh sách ngành học trong hệ thống
                </p>
            </div>

            <div class="flex items-center gap-3">
                <x-admin.search />

                <a href="{{ route('admin.grades.create') }}"
                    class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition shadow-sm">
                    + Thêm ngành học
                </a>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto rounded-xl border">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-600 text-sm uppercase tracking-wide">
                    <tr>
                        <th class="p-4">Mã ngành học</th>
                        <th class="p-4">Tên ngành học</th>
                        <th class="p-4">Thứ tự</th>
                        <th class="p-4 text-center">Trạng thái</th>
                        <th class="p-4 text-center">Hành động</th>
                    </tr>
                </thead>

                <tbody class="divide-y text-gray-700">
                    @forelse ($grades as $grade)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4 font-medium">
                                #{{ $grade->id }}
                            </td>

                            <td class="p-4">
                                {{ $grade->name }}
                            </td>

                            <td class="p-4">
                                {{ $grade->sort_order ?? 'Chưa xác định' }}
                            </td>

                            <td class="p-4 text-center">
                                <div class="inline-flex items-center">
                                    <x-admin.status :url="route('admin.grades.toggleStatus', $grade->id)" :status="$grade->status" />
                                </div>
                            </td>

                            <td class="p-4">
                                <div class="flex justify-center items-center gap-3">

                                    <a href="{{ route('admin.grades.edit', $grade->id) }}"
                                        class="text-blue-600 hover:text-blue-800 transition">
                                        <x-heroicon-s-pencil-square class="w-5 h-5" />
                                    </a>

                                    <form action="{{ route('admin.grades.destroy', $grade->id) }}" method="POST"
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
                                Chưa có ngành học nào
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer --}}
        <div class="flex items-center justify-between mt-6">

            <a href="{{ route('admin.grades.trash') }}"
                class="text-sm text-red-600 hover:text-red-800 flex items-center gap-2">
                <x-heroicon-o-trash class="w-5 h-5" />
                Danh sách đã xóa
            </a>

            {{ $grades->links() }}

        </div>

    </div>
@endsection
