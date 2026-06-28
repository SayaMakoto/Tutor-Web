@extends('layouts.admin')
@section('title', 'Thêm môn học')

@section('content')

    <div class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('admin.subjects.index') }}" class="hover:text-violet-600 transition">Môn học</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-800 font-medium">Thêm mới</span>
    </div>

    <div class="max-w-lg">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                <div class="w-9 h-9 bg-violet-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-plus text-violet-600 text-sm"></i>
                </div>
                <h2 class="font-bold text-gray-800">Thêm môn học mới</h2>
            </div>

            <form action="{{ route('admin.subjects.store') }}" method="POST" class="p-6 space-y-5">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5">Tên môn học <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i class="fas fa-book absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               placeholder="Ví dụ: Toán, Văn, Tiếng Anh..."
                               class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm
                                      focus:ring-2 focus:ring-violet-400 focus:border-transparent focus:outline-none">
                    </div>
                    @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <a href="{{ route('admin.subjects.index') }}"
                       class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-sm font-semibold transition">
                        Hủy
                    </a>
                    <button type="submit"
                            class="px-5 py-2.5 bg-gradient-to-r from-violet-600 to-indigo-600 text-white rounded-xl text-sm font-semibold hover:shadow-md transition">
                        <i class="fas fa-save mr-1.5 text-xs"></i> Lưu môn học
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection
