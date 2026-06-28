@extends('layouts.admin')
@section('title', 'Thùng rác — Môn học')

@section('content')

    <div class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('admin.subjects.index') }}" class="hover:text-violet-600 transition">Môn học</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-800 font-medium">Thùng rác</span>
    </div>

    <div class="flex items-center justify-between mb-4">
        <div>
            <h1 class="text-xl font-bold text-gray-800">Môn học đã xóa</h1>
            <p class="text-sm text-gray-500 mt-0.5">Khôi phục hoặc xóa vĩnh viễn</p>
        </div>
        <div class="flex items-center gap-2 bg-red-50 border border-red-100 rounded-xl px-4 py-2">
            <i class="fas fa-trash-can text-red-400 text-sm"></i>
            <span class="text-sm font-semibold text-red-600">{{ $subjects->total() }} mục</span>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Môn học</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Ngành học</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Khôi phục</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Xóa vĩnh viễn</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($subjects as $subject)
                        <tr class="hover:bg-gray-50/70 transition">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-red-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-book text-red-400 text-xs"></i>
                                    </div>
                                    <p class="font-medium text-gray-500 line-through">{{ $subject->name }}</p>
                                </div>
                            </td>
                            <td class="px-5 py-3.5">
                                <div class="flex flex-wrap gap-1">
                                    @forelse($subject->grades as $grade)
                                        <span class="text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full">
                                            {{ $grade->name }}
                                        </span>
                                    @empty
                                        <span class="text-xs text-gray-300">—</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                <form action="{{ route('admin.subjects.restore', $subject->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-600 rounded-lg text-xs font-semibold transition">
                                        <i class="fas fa-rotate-left text-xs"></i> Khôi phục
                                    </button>
                                </form>
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                <form action="{{ route('admin.subjects.forceDelete', $subject->id) }}" method="POST"
                                      onsubmit="return confirm('Xóa vĩnh viễn? Không thể hoàn tác!')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg text-xs font-semibold transition">
                                        <i class="fas fa-trash text-xs"></i> Xóa hẳn
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-12 text-center">
                                <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-box-open text-gray-300 text-xl"></i>
                                </div>
                                <p class="text-gray-500 font-medium text-sm">Thùng rác trống</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-3.5 border-t border-gray-100 flex items-center justify-between">
            <a href="{{ route('admin.subjects.index') }}"
               class="flex items-center gap-1.5 text-sm text-violet-600 hover:text-violet-800 font-medium transition">
                <i class="fas fa-arrow-left text-xs"></i> Quay lại
            </a>
            {{ $subjects->links() }}
        </div>
    </div>

@endsection
