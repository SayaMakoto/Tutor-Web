@extends('layouts.admin')
@section('title', 'Chỉnh sửa môn học')
@section('content')
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-gray-700">
            Chỉnh sửa môn học
        </h2>
        <form action="{{ route('admin.subjects.update', $subject->id) }}" method="POST" class="space-y-6">

            @csrf
            @method('PUT')

            <!-- Tên môn học -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">
                    Tên môn học
                </label>
                <input type="text" name="name" value="{{ old('name', $subject->name) }}"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>
            <!-- Ngành học -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-3">
                    Thuộc ngành học
                </label>

                <div class="grid grid-cols-3 gap-3">
                    @foreach ($grades as $grade)
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="grades[]" value="{{ $grade->id }}"
                                {{ in_array($grade->id, old('grades', $subject->grades->pluck('id')->toArray())) ? 'checked' : '' }}
                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">

                            <span>{{ $grade->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
            <!-- Nút -->
            <div class="flex justify-end space-x-4 pt-4">
                <a href="{{ route('admin.subjects.index') }}"
                    class="px-6 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 transition">
                    Hủy
                </a>
                <button type="submit" class="px-6 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">
                    Lưu ngành học
                </button>
            </div>
        </form>
    </div>
@endsection
