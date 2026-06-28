@extends('layouts.admin')
@section('title', 'Thùng rác — Đơn đăng lớp')

@section('content')

    <div class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('admin.class-requests.index') }}" class="hover:text-violet-600 transition">Đơn đăng lớp</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-800 font-medium">Thùng rác</span>
    </div>

    <div class="flex items-center justify-between mb-4">
        <div>
            <h1 class="text-xl font-bold text-gray-800">Đơn đăng lớp đã xóa</h1>
            <p class="text-sm text-gray-500 mt-0.5">Xem hoặc xóa vĩnh viễn</p>
        </div>
        <div class="flex items-center gap-2 bg-red-50 border border-red-100 rounded-xl px-4 py-2">
            <i class="fas fa-trash-can text-red-400 text-sm"></i>
            <span class="text-sm font-semibold text-red-600">{{ $classRequests->total() }} mục</span>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Mã</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Học viên</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Chi tiết</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Xóa vĩnh viễn</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($classRequests as $request)
                        <tr class="hover:bg-gray-50/70 transition">
                            <td class="px-5 py-3.5">
                                <span class="font-mono text-xs bg-red-50 text-red-500 px-2 py-1 rounded-lg">#{{ $request->id }}</span>
                            </td>
                            <td class="px-5 py-3.5 font-medium text-gray-500 line-through">
                                {{ $request->student_name }}
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                <a href="{{ route('admin.class-requests.show', $request->id) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg text-xs font-semibold transition">
                                    <i class="fas fa-eye text-xs"></i> Xem
                                </a>
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                <form action="{{ route('admin.class-requests.forceDelete', $request->id) }}" method="POST"
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
            <a href="{{ route('admin.class-requests.index') }}"
               class="flex items-center gap-1.5 text-sm text-violet-600 hover:text-violet-800 font-medium transition">
                <i class="fas fa-arrow-left text-xs"></i> Quay lại
            </a>
            {{ $classRequests->links() }}
        </div>
    </div>

@endsection
