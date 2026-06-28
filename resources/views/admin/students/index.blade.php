@extends('layouts.admin')
@section('title', 'Quản lý học viên')

@section('content')

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-800">Quản lý học viên</h1>
            <p class="text-sm text-gray-500 mt-0.5">Danh sách tất cả học viên đã đăng ký</p>
        </div>
        <div class="flex items-center gap-2 bg-blue-50 border border-blue-100 rounded-xl px-4 py-2">
            <i class="fas fa-user-graduate text-blue-500 text-sm"></i>
            <span class="text-sm font-semibold text-blue-700">{{ $students->total() }} học viên</span>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Học viên</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden sm:table-cell">Email</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Chi tiết</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($students as $student)
                        <tr class="hover:bg-gray-50/70 transition">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $student->user->avatar
                                        ? asset('storage/' . $student->user->avatar)
                                        : 'https://ui-avatars.com/api/?name=' . urlencode($student->user->name) . '&background=1d4ed8&color=fff' }}"
                                         class="w-9 h-9 rounded-full object-cover flex-shrink-0" alt="avatar">
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $student->user->name }}</p>
                                        <p class="text-xs text-gray-400 sm:hidden">{{ $student->user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-gray-500 hidden sm:table-cell">
                                {{ $student->user->email }}
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                <a href="{{ route('admin.students.show', $student->id) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg text-xs font-semibold transition">
                                    <i class="fas fa-eye text-xs"></i> Xem
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-5 py-12 text-center">
                                <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-user-graduate text-gray-300 text-xl"></i>
                                </div>
                                <p class="text-gray-500 font-medium text-sm">Chưa có học viên nào</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($students->hasPages())
            <div class="px-5 py-3 border-t border-gray-100">
                {{ $students->links() }}
            </div>
        @endif
    </div>

@endsection
